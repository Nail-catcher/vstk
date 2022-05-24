<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CitiesResource;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return CitiesResource
     */
    public function __invoke(Request $request): CitiesResource
    {
        return new CitiesResource(City::all());
    }
}
