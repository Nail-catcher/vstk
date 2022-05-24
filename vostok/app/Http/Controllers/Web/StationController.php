<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StationFilter;
use App\Http\Resources\StationsResource;
use App\Models\Station;

class StationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param StationFilter $request
     * @return StationsResource
     */
    public function __invoke(StationFilter $request): StationsResource
    {
        $data = $request->validated();
        $stations = Station::with('area', 'division', 'division.user')->withCount('applications');
        $stations->filter($data);
        return new StationsResource($stations->orderBy('bts_id')->paginate());
    }
}
