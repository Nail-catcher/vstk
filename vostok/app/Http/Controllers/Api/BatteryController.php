<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BatteriesResource;
use App\Models\Group;
use App\Models\Station;

class BatteryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Station $station
     * @param Group $group
     * @return BatteriesResource
     */
    public function __invoke(Station $station, Group $group): BatteriesResource
    {
        return new BatteriesResource($group->batteries);
    }
}
