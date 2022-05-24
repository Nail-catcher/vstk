<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StartingResource;
use App\Models\Application;
use App\Models\ApplicationStation;
use App\Models\Starting;
use App\Models\Station;
use Illuminate\Http\Request;

class ApplicationStationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Application $application
     * @param Station $station
     * @return StartingResource
     */
    public function __invoke(Request $request, Application $application, Station $station): StartingResource
    {
        $pivot = ApplicationStation::where('application_id', '=', $application->id)
            ->where('station_id', '=', $station->id)->firstOrFail(['starting_id']);
        $starting = Starting::with([
            'progresses',
            'progresses.progress',
            'progresses.typeable',
            'progresses.typeable.modelable',
            'progresses.inventories',
            'progresses.images',
            'progresses.works',
        ])->where('id', '=', $pivot->starting_id)->firstOrFail();
        return new StartingResource($starting);
    }
}
