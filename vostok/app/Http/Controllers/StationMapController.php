<?php

namespace App\Http\Controllers;

use App\Http\Requests\StationFilter;
use App\Http\Resources\StationsResource;
use App\Models\Area;
use App\Models\Station;
use Inertia\Inertia;

class StationMapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param StationFilter $request
     * @return \Inertia\Response
     */
    public function __invoke(StationFilter $request): \Inertia\Response
    {
        $stations = Station::with('state', 'region', 'city')->withCount('applications');
        $stations->filter($request->validated());
        return Inertia::render('Stations/Map', [
            'areas' => Area::all(),
            'stations' => new StationsResource($stations->paginate()->appends($request->all()))
        ]);
    }
}
