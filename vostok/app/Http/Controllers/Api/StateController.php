<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StatesResource;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return StatesResource
     */
    public function __invoke(Request $request)
    {
        return new StatesResource(State::all());
    }
}
