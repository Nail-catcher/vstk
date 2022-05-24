<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationFilter;
use App\Http\Resources\ApplicationsResource;
use App\Models\Station;
use Inertia\Inertia;

class ApplicationStationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param ApplicationFilter $request
     * @param Station $station
     * @return \Inertia\Response
     */
    public function __invoke(ApplicationFilter $request, Station $station): \Inertia\Response
    {
        $input = $request->validated();
        $applications = $station->applications()
            ->with([
                'user',
                'engineer',
                'stations',
                'project',
                'type',
                'works',
                'status',
                'routes'
            ])
            ->latest();
        $applications->filter($input);
        return Inertia::render('Stations/Application', [
            'station' => $station,
            'applications' => new ApplicationsResource($applications->paginate()->appends($input)),
        ]);
    }
}
