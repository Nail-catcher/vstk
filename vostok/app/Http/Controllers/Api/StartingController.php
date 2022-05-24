<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StartingResource;
use App\Models\Application;
use Illuminate\Http\Request;

class StartingController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Application $application
     * @return StartingResource
     */
    public function __invoke(Request $request, Application $application): StartingResource
    {
        $application->lastStarting->load([
            'type',
            'user',
            'station:id,bts_id,location',
            'protocols',
            'progresses',
            'progresses.typeable',
            'progresses.typeable.modelable',
            'progresses.inventories',
            'progresses.images',
            'progresses.works'
        ]);

        return new StartingResource($application->lastStarting);
    }
}
