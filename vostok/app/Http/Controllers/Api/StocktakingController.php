<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StocktakingsResource;
use App\Models\Station;

class StocktakingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Station $station
     * @return StocktakingsResource
     */
    public function __invoke(Station $station): StocktakingsResource
    {
        return new StocktakingsResource($station->stationType->stocktakings);
    }
}
