<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\RouteLocationsResource;
use App\Models\Route;
use Illuminate\Http\Request;

class RouteLocationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Route $route
     * @return RouteLocationsResource
     */
    public function __invoke(Request $request, Route $route): RouteLocationsResource
    {
        return new RouteLocationsResource($route->locations);
    }
}
