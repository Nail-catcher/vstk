<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationFilter;
use App\Http\Resources\ApplicationsResource;
use App\Models\Area;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * Display the specified resource.
     *
     * @param ApplicationFilter $request
     * @param \App\Models\Area $area
     * @return \Inertia\Response
     */
    public function show(ApplicationFilter $request, Area $area): \Inertia\Response
    {
        $input = $request->validated();
        $applications = $area->applications()->with([
            'user:id,lastname,firstname',
            'engineer:id,lastname,firstname',
            'project',
            'stations',
            'routes',
            'type',
            'works',
            'status',
        ])->latest();
        // if (!isset($input['statuses']) && !isset($input['status'])) {
        //     $applications->active();
        // }
        $applications->filter($input);
        return Inertia::render('Areas/Show', [
            'area' => $area,
            'applications' => new ApplicationsResource($applications->paginate()->appends($request->validated()))
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Area $area
     * @return \Illuminate\Http\Response
     */
    public function edit(Area $area)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Area $area
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Area $area)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Area $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
        //
    }
}
