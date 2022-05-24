<?php

namespace App\Http\Controllers;

use App\Http\Requests\StationFilter;
use App\Http\Resources\StationsResource;
use App\Models\Application;
use App\Models\Area;
use App\Models\Station;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param StationFilter $request
     * @return \Inertia\Response
     */
    public function index(StationFilter $request): \Inertia\Response
    {
        $input = $request->validated();
        $stations = Station::with('state', 'division', 'area')
            ->withCount('applications');
        $stations->filter($input);
        return Inertia::render('Stations/Index', [
            'areas' => Area::all(),
            'stations' => new StationsResource($stations->paginate()->appends($input))
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param Station $station
     * @return \Inertia\Response
     */
    public function show(Station $station): \Inertia\Response
    {
        return Inertia::render('Stations/Show', [
            'station' => $station
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('Stations/Create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Application $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        //
    }
}
