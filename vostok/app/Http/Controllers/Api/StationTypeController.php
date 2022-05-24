<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Station;
use App\Models\StationType;
use Illuminate\Http\Request;

class StationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Station $station)
    {
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
     * @param \App\Models\StationType $stationType
     * @return \Illuminate\Http\Response
     */
    public function show(StationType $stationType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\StationType $stationType
     * @return \Illuminate\Http\Response
     */
    public function edit(StationType $stationType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\StationType $stationType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StationType $stationType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\StationType $stationType
     * @return \Illuminate\Http\Response
     */
    public function destroy(StationType $stationType)
    {
        //
    }
}
