<?php


namespace App\Actions\Applications;


use App\Events\ApplicationUpdated;
use App\Models\Application;
use App\Models\ApplicationStatus;
use App\Models\Status;
use App\Models\User;
use App\Notifications\ApplicationAccepted;
use App\Notifications\ApplicationRefinement;
use App\Notifications\ApplicationRejectedByDispatcher;
use App\Notifications\ApplicationUserAssign;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UpdateApplication
{
    public function update(Application $application, array $input)
    {
        $application->fill($input);
        
        $user = Auth::user();
        if (isset($input['status'])) {
            $status = new ApplicationStatus([
                'status_id' => $application->status_id,
                'comment' => $input['comment'] ?? null
            ]);
            $status->old_status()->associate($application->status_id);
            $status->status()->associate($input['status']);
            $status->user()->associate($user);
            $status->application()->associate($application);
            $status->save();
            $application->status()->associate($input['status']);
            $application->attempts = 0;

            if (($application->status->id === Status::ACCEPTED) && $application->user->one_signal_token !== null) {
                $application->user->notify(new ApplicationAccepted($application, $application->engineer));
            } elseif ($application->status->id === Status::REJECTED && ($application->dispatcher->id === $user->id || $user->hasRole('dispatcher'))) {
                $application->engineer->notify(new ApplicationRejectedByDispatcher($application));
                $application->users->each(fn(User $user) => $user->notify(new ApplicationRejectedByDispatcher($application)));
                $this->uncompleteStations($application->id);
            } elseif ($application->status->id === Status::IN_WORK) {
                $users = $application->users()->pluck('id')->toArray();
                Validator::make([
                    'users' => $users
                ], [
                    'users' => ['nullable', 'array'],
                ])->validate();
            } elseif ($application->status->id === Status::NEW) {
                $application->engineer()->associate(null);
                $application->users()->detach();
                $this->uncompleteStations($application->id);
            } elseif ($application->status->id === Status::REFINEMENT) {
                $this->uncompleteStations($application->id);
                $application->engineer->notify(new ApplicationRefinement($application));
                $application->users->each(fn(User $user) => $user->notify(new ApplicationRefinement($application)));
                if (isset($application->routes->last()->id)) {
                    $application->exRoutes()->attach($application->routes->last()->id);
                    $application->routes()->detach($application->routes->last()->id);
                }
                

            }
        }
        if (isset($input['engineer'])) {
            $application->engineer()->associate($input['engineer']);
        }
        if (!empty($input['users']) && is_array($input['users'])) {
            $input['users'] = array_unique($input['users'], SORT_NUMERIC);
            Arr::forget($input['users'], $input['engineer']);
            $application->users()->sync($input['users']);
            $application->users->each(fn(User $user) => $user->notify(new ApplicationUserAssign($application)));
        }
        $application->save();
        $application->load([
            'user',
            'engineer',
            'users',
            'comments',
            'area',
            'project',
            'stations',
            'type',
            'work',
            'works',
            'status',
            'statuses'
        ]);
        broadcast(new ApplicationUpdated($application))->toOthers();
        return $application;
    }

    public function uncompleteStations($id)
    {
        DB::table('application_station')
            ->where('application_id', '=', $id)
            ->update([
                'is_complete' => false,
                'starting_id' => null
            ]);
        DB::table('applications')
            ->where('id', '=', $id)
            ->update([
                'starting_id' => null
            ]);
    }
}
