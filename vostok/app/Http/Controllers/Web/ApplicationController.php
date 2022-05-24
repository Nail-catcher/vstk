<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationFilter;
use App\Http\Requests\ApplicationShow;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\ApplicationsResource;
use App\Models\Application;
use App\Models\Status;

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
        $input = $request->validated();
        $applications = Application::with([
            'stations',
            'stations.area',
            'type',
            'area',
            'division',
            'users'
        ])->latest();
        if (!isset($input['statuses']) && !isset($input['status'])) {
            $applications->whereIn('status_id', [
                Status::NEW, Status::ACCEPTED, Status::IN_WORK, Status::REFINEMENT, 
            ]);
        }
            
        $applications->filter($input);
        return new ApplicationsResource($applications->paginate());
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
        $application->load([
            'user:id,lastname,firstname',
            'users:id,lastname,firstname',
            'engineer:id,lastname,firstname',
            'area',
            'project',
            'startings',
            'startings.user',
            'startings.station:id,bts_id,location',
            'startings.progresses',
            'startings.progresses.typeable',
            'startings.progresses.typeable.modelable',
            'startings.progresses.progress',
            'startings.progresses.inventories',
            'startings.progresses.images',
            'startings.progresses.works',
            'type',
            'works',
            'routes',
            'stations',
            'images:id,path',
            'comments:id,comment',
            'statuses',
            'statuses.pivot.user:id,lastname,firstname',
            'statuses.pivot.old_status',
            'accepts',
            'accepts.user:id,lastname,firstname',
            'accepts.users:id,lastname,firstname',
        ]);
        return (new ApplicationResource($application));
    }
}
