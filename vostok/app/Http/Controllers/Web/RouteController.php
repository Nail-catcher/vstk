<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\RouteResource;
use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Route $route
     * @return RouteResource
     */
    public function __invoke(Request $request, Route $route): RouteResource
    {
        $route->load('applications');
        return new RouteResource($route);
    }
}
