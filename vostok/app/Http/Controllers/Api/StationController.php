<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StationFilter;
use App\Http\Resources\StationResource;
use App\Http\Resources\StationsResource;
use App\Models\Station;

class StationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param StationFilter $request
     * @return StationsResource
     */
    public function index(StationFilter $request): StationsResource
    {
        $data = $request->validated();
        $stations = Station::with('area', 'state', 'region', 'city','project')->withCount('applications');
        $stations->filter($data);
        $stations->where('division_id', $request->user()->division->id);
        $stations->orderBy('bts_id');
        return new StationsResource($stations->paginate($data['limit'] ?? null)->appends($data));
    }

    /**
     * Display the specified resource.
     *
     * @param Station $station
     * @return StationResource
     */
    public function show(Station $station): StationResource
    {
        return new StationResource($station->load([
            'area',
            'state',
            'region',
            'city',
            'applications',
            'applications.type',
            'applications.work',
            'applications.works',
            'applications.status'
        ]));
    }
}
