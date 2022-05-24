<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GroupsResource;
use App\Models\Station;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Station $station
     * @return GroupsResource
     */
    public function __invoke(Request $request, Station $station): GroupsResource
    {
        return new GroupsResource($station->groups);
    }
}
