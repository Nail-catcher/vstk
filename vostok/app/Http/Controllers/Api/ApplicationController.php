<?php

namespace App\Http\Controllers\Api;

use App\Actions\Applications\UpdateApplication;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationFilter;
use App\Http\Requests\ApplicationShow;
use App\Http\Requests\ApplicationStore;
use App\Http\Requests\ApplicationUpdate;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\ApplicationsResource;
use App\Models\Application;
use App\Models\Area;
use App\Models\Status;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ApplicationFilter $request
     * @return ApplicationsResource
     */
    public function index(ApplicationFilter $request): ApplicationsResource
    {
        $data = $request->validated();
        $applications = Application::with([
            'type',
            'work',
            'works',
            'status',
            'user',
            'engineer',
            'users',
            'stations',
            'division',
            'routes.activity',
            'routes.engineer',
            'routes.users',
        ])
            ->orderByPriority()
            ->latest()
            ->orderByDeadlineAt();
        $applications->filter($data);
        $user = Auth::user();
        if ($user->hasRole('engineer')) {
            $applications->where(function (Builder $query) use ($user) {
                $query->whereNull('engineer_id')
                    ->orWhereIn('status_id', [
                        Status::ACCEPTED,
                        Status::NEW,
                        Status::REFINEMENT,
                        Status::COMPLETED,
                    ])
                    ->orWhere('engineer_id', '=', $user->id)
                    ->orWhereHas('users', function (Builder $query) use ($user) {
                        $query->where('user_id', '=', $user->id);
                    })
                    ->orWhereHas('routes', function (Builder $query) use ($user) {
                        $query->whereHas('users', function (Builder $query) use ($user) {
                            $query->where('user_id', '=', $user->id);
                        });
                    });
            });
        }
        if ($user->hasPermission('division.applications') && !$user->hasRole('admin')) {
            $applications->where('division_id', '=', $user->division_id);
        }
        return new ApplicationsResource($applications->paginate($data['limit'] ?? null)->appends($data));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ApplicationStore $request
     * @return ApplicationResource
     */
    public function store(ApplicationStore $request): ApplicationResource
    {

        $data = $request->validated();
        $area = Area::with('division.user')->find($data['area']);
        $application = new Application();
        $application->fill($data);
        $application->user()->associate($area->division->user_id);
        $application->engineer()->associate($data['engineer']);
        $application->type()->associate($data['type']);
        $application->project()->associate($data['project']);
        $application->area()->associate($area);
        $application->work()->associate($data['work']);
        $application->save();
        if ($request->filled('users')) {
            $application->users()->attach($data['users']);
        }
        if ($request->filled('stations')) {
            $application->stations()->attach($data['stations']);
        }
        if ($application->user->one_signal_token !== null) {
            $application->user->notify(new \App\Notifications\ApplicationStore($application));
        }
        if ($application->engineer !== null && $application->engineer->one_signal_token !== null) {
            $application->engineer->notify(new \App\Notifications\ApplicationStore($application));
        }
        return new ApplicationResource(
            $application->load([
                'user',
                'project',
                'type',
                'work',
                'works',
                'status',
                'users',
                'status',
                'statuses'
            ])
        );
    }

    /**
     * Display the specified resource.
     *
     * @param ApplicationShow $request
     * @param Application $application
     * @return ApplicationResource
     */
    public function show(ApplicationShow $request, Application $application): ApplicationResource
    {

        if ($request->filled('location_lat') && $request->filled('location_lng')) {
            $point = new Point($request->location_lat, $request->location_lng);
            $application->load(['stations' => function ($query) use ($point) {
                $query->distanceSphereValue('location', $point);
            }]);
        } else {
            $application->load('stations');
        }
        $application->load([
            'user',
            'users',
            'area',
            'project',
            'images',
            'engineer',
            'startings',
            'startings.user',
            'startings.type',
            'startings.station',
            'startings.progresses',
            'startings.progresses.progress',
            'startings.progresses.inventories',
            'startings.progresses.images',
            'type',
            'work',
            'works',
            'status',
            'statuses',
            'statuses.pivot.user',
            'statuses.pivot.old_status',
            'comments',
            'comments.user',
            'accepts',
            'accepts.user:id,lastname,firstname',
            'accepts.users:id,lastname,firstname',
            'applicationReport',
            'applicationReport.images',
            'applicationReport.engineer',
            'applicationReport.works',
            'routes.activity',
            'routes.engineer',
            'routes.users',
        ]);

        return (new ApplicationResource($application));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ApplicationUpdate $request
     * @param Application $application
     * @return ApplicationResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(ApplicationUpdate $request, Application $application): ApplicationResource
    {

        (new UpdateApplication())->update($application, $request->validated());
        return new ApplicationResource($application);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
