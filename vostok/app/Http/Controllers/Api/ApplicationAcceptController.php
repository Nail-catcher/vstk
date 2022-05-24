<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationAcceptStore;
use App\Http\Requests\ApplicationAcceptUpdate;
use App\Http\Resources\ApplicationAcceptResource;
use App\Models\Application;
use App\Models\ApplicationAccept;
use App\Models\Status;
use App\Notifications\ApplicationAccepted;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Models\ApplicationStatus;


class ApplicationAcceptController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param ApplicationAcceptStore $request
     * @param Application $application
     * @return ApplicationAcceptResource
     */
    public function store(ApplicationAcceptStore $request, Application $application): ApplicationAcceptResource
    {
        $input = $request->validated();
        if (isset($input['comment'])) {
            $accept = new ApplicationAccept([

                'comment' => $input['comment']

            ]);
        } else {
            $accept = new ApplicationAccept([
                'comment' => ' '
            ]);
        }
        $accept->user()->associate(Auth::id());
        $accept->application()->associate($application);
        $accept->save();
        $accept->users()->attach($input['users'] ?? null);
        
            
        $application->attempts = 0;
        $application->lastStarting()->associate(null);
        $status = new ApplicationStatus([
                'status_id' => $application->status_id,
                
            ]);
            $status->old_status()->associate($application->status_id);
            
            $status->user()->associate(Auth::id());
            $status->application()->associate($application);

        if (isset($input['users'])) {
            $input['users'] = array_unique($input['users'], SORT_NUMERIC);
            Arr::forget($input['users'], Auth::id());
            $application->status()->associate(Status::IN_WORK);

        } else {
            $application->status()->associate(Status::ACCEPTED);
        }
        $application->engineer()->associate(Auth::id());
        $application->users()->sync($input['users'] ?? null);

        $application->save();
        $status->status()->associate($application->status_id);
        $status->save();
            
        $application->user->notify(new ApplicationAccepted($application, $application->engineer));
        $application->dispatcher->notify(new ApplicationAccepted($application, $application->engineer));

        return new ApplicationAcceptResource(
            $accept->load([
                'user',
                'users'
            ])
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ApplicationAcceptUpdate $request
     * @param Application $application
     * @return ApplicationAcceptResource
     */
    public function update(ApplicationAcceptUpdate $request, Application $application): ApplicationAcceptResource
    {
        $input = $request->validated();
        if (isset($input['users'])) {
        $input['users'] = array_unique($input['users'], SORT_NUMERIC);
        Arr::forget($input['users'], Auth::id());
        }
        if (isset($input['comment'])) {
            $accept = new ApplicationAccept([

                'comment' => $input['comment']

            ]);
        } else {
            $accept = new ApplicationAccept([
                'comment' => ' '
            ]);
        }
        $accept->user()->associate($input['engineer']);
        $accept->application()->associate($application);
        $accept->save();

        $application->attempts = 0;
        $application->lastStarting()->associate(null);
        $application->status()->associate(Status::ACCEPTED);
        $application->engineer()->associate($input['engineer']);
        $application->save();

        $application->user->notify(new ApplicationAccepted($application, $application->engineer));
        $application->dispatcher->notify(new ApplicationAccepted($application, $application->engineer));

        return new ApplicationAcceptResource(
            $accept->load([
                'user',
                'users'
            ])
        );
    }
}
