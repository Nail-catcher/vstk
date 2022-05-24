<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SensorsResource;
use App\Models\Station;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Station $station
     * @return SensorsResource
     */
    public function __invoke(Request $request, Station $station): SensorsResource
    {
        return new SensorsResource($station->sensors);
    }
}
