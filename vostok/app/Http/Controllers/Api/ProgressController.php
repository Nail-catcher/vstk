<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PreventiveStore;
use App\Http\Requests\ProgressArrived;
use App\Http\Requests\ProgressInstall;
use App\Http\Requests\ProgressInventory;
use App\Http\Requests\ProgressKeys;
use App\Http\Requests\ProgressReport;
use App\Http\Requests\ProgressStart;
use App\Http\Resources\InventoriesResource;
use App\Http\Resources\StartingResource;
use App\Models\Application;
use App\Models\ApplicationReport;
use App\Models\PreventiveWork;
use App\Models\Progress;
use App\Models\Starting;
use App\Models\StartingProgress;
use App\Models\Status;
use App\Notifications\ApplicationCompleted;
use App\Notifications\ApplicationStart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\ApplicationStatus;

class ProgressController extends Controller
{

    /**
     * @param ProgressStart $request
     * @param Application $application
     * @return StartingResource
     */
    public function start(ProgressStart $request, Application $application): StartingResource
    {
        $input = $request->validated();
        $user = Auth::user();

        $starting = new Starting();
        $starting->application()->associate($application);
        $starting->user()->associate($user);
        $starting->station()->associate($input['station']);
        $starting->type()->associate($input['type']);
        $starting->save();

        $progress = new StartingProgress([
            'comment' => $input['comment'] ?? null
        ]);
        $progress->starting()->associate($starting);
        $progress->progress()->associate(Progress::START);
        $progress->save();

        $application->user->notify(new ApplicationStart($application, $application->engineer));
        $application->dispatcher->notify(new ApplicationStart($application, $application->engineer));

        if ($application->started_at === null) {
            $application->started_at = now();
        }
        $application->status()->associate(Status::IN_WORK);
        $application->lastStarting()->associate($starting);
        $application->save();

        DB::table('application_station')
            ->where('application_id', '=', $application->id)
            ->where('station_id', '=', $input['station'])
            ->update([
                'is_active' => true,
                'starting_id' => $starting->id
            ]);
        return new StartingResource($application->lastStarting);
    }

    /**
     * @param ProgressKeys $request
     * @param Application $application
     */
    public function keys(ProgressKeys $request, Application $application): void
    {
        $input = $request->validated();
        $progress = new StartingProgress([
            'comment' => $input['comment'] ?? null,
            'step_id' => $input['step'] ?? null
        ]);
        $progress->progress()->associate(Progress::KEYS);
        $progress->starting()->associate($application->starting_id);
        $progress->save();
    }

    /**
     * @param ProgressInventory $request
     * @param Application $application
     */
    public function inventory(ProgressInventory $request, Application $application): void
    {
        $input = $request->validated();
        $progress = new StartingProgress([
            'comment' => $input['comment'] ?? null,
            'step_id' => $input['step'] ?? null
        ]);
        $progress->progress()->associate(Progress::INVENTORY);
        $progress->starting()->associate($application->starting_id);
        $progress->save();
        if (isset($input['inventories']) && is_array($input['inventories'])) {
            $progress->inventories()->attach($input['inventories']);
        }
    }

    /**
     * @param ProgressArrived $request
     * @param Application $application
     */
    public function arrived(ProgressArrived $request, Application $application): void
    {
        $input = $request->validated();
        $progress = new StartingProgress([
            'comment' => $input['comment'] ?? null,
            'step_id' => $input['step'] ?? null
        ]);
        $progress->progress()->associate(Progress::ARRIVED);
        $progress->starting()->associate($application->starting_id);
        $progress->save();
    }

    /**
     * @param ProgressInstall $request
     * @param Application $application
     */
    public function install(ProgressInstall $request, Application $application): InventoriesResource
    {
        $input = $request->validated();

        $progress = new StartingProgress([
            'comment' => $input['comment'] ?? null
        ]);
        $progress->progress()->associate(Progress::INSTALL);
        $progress->starting()->associate($application->starting_id);
        $progress->save();

        $progress->inventories()->attach($input['inventories']);
        $request->user()->inventories()->updateExistingPivot($input['inventories'], [
            'installed_at' => now()
        ]);
        return new InventoriesResource($request->user()->inventories()->wherePivotNull('installed_at')->get());
    }

    /**
     * @param ProgressReport $request
     * @param Application $application
     */
    public function report(ProgressReport $request, Application $application): void
    {
        $input = $request->validated();

        $progress = new StartingProgress([
            'comment' => $input['comment'] ?? null
        ]);
        $progress->progress()->associate(Progress::REPORT);
        $progress->starting()->associate($application->starting_id);
        $progress->save();

        

        $application->stations()->updateExistingPivot($application->lastStarting->station_id, [
            'is_complete' => true,
            'is_active' => false
        ]);
        if (isset($input['works'])) {
            $progress->works()->sync($input['works']);
            $application->works()->syncWithoutDetaching($input['works']);
        }
        

        $application->lastStarting()->associate(null);
        $application->save();
        if (!empty($input['images'])) {
            $application->images()->whereNull('attached_at')
                ->whereIn('id', $input['images'])
                ->where('imageable_type', 'App\Models\Application')
                ->where('imageable_id', $application->id)
                ->update([
                    'imageable_type' => 'App\Models\StartingProgress',
                    'imageable_id' => $progress->id,
                    'attached_at' => now()
                ]);
        }
    }

    /**
     * @param Request $request
     * @param Application $application
     * @throws \Illuminate\Validation\ValidationException
     */
    public function complete(ProgressReport $request, Application $application): void
    {

        Validator::make([
            'startings' => $application->stations()->wherePivot('is_complete', '=', true)->count()
        ], [
            'startings' => ['required', 'integer', "min:{$application->stations()->count()}"],
        ], [
            'startings.min' => 'Не выполнены работы по всем БС.'
        ])->validate();

        $input = $request->validated();
        $reportapp = new ApplicationReport([
            'comment' => $input['comment'] ?? null,
            'engineer_id' => $application->engineer->id
        ]);
        $reportapp->engineer()->associate(Auth::id());
        $reportapp->application()->associate($application->id);
        $reportapp->save();

        $reportapp->works()->attach($input['works']);
        if (!empty($input['images'])) {
            $application->images()->whereNull('attached_at')
                ->whereIn('id', $input['images'])
                ->where('imageable_type', 'App\Models\Application')
                ->where('imageable_id', $application->id)
                ->update([
                    'imageable_type' => 'App\Models\ApplicationReport',
                    'imageable_id' => $reportapp->id,
                    'attached_at' => now()
                ]);
        }
        $status = new ApplicationStatus([
                'status_id' => $application->status_id,                
            ]);
            $status->old_status()->associate($application->status_id);
            $status->user()->associate(Auth::id());
            $status->application()->associate($application);
        $application->works()->syncWithoutDetaching($input['works']);
        $application->status()->associate(Status::COMPLETED);
        $application->ended_at = now();
        $application->save();
        $status->status()->associate($application->status_id);
        $status->save();
            
        $application->user->notify(new ApplicationCompleted($application, $application->engineer));
        $application->dispatcher->notify(new ApplicationCompleted($application, $application->engineer));

    }

    /**
     * @param PreventiveStore $request
     * @param Application $application
     */
    public function preventive(PreventiveStore $request, Application $application): void
    {
        $input = $request->validated();
        $preventive = new PreventiveWork($input);
        if (isset($input['model'], $input['model_id'])) {
            $model = $input['model']::find($input['model_id']);
            $preventive->modelable()->associate($model);
        }
        $preventive->save();

        $progress = new StartingProgress([
            'comment' => $input['comment'] ?? null
        ]);
        $progress->progress()->associate($input['progress']);
        $progress->starting()->associate($application->starting_id);
        $progress->typeable()->associate($preventive);
        $progress->save();
    }
}
