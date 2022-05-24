<?php

namespace App\Http\Controllers\Api;

use App\Events\RouteLocationUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\RouteLocationStore;
use App\Models\Route;
use App\Models\RouteLocation;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Support\Facades\Auth;

class RouteLocationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param RouteLocationStore $request
     * @param Route $route
     * @return void
     */
    public function __invoke(RouteLocationStore $request, Route $route)
    {
        $input = $request->validated();
        $user = Auth::user();
        if (!$user->hasPermission('location.routes')) {
            return;
        }
        $locations = collect();
        foreach ($input['locations'] as $item) {
            $location = new RouteLocation();
            $location->user()->associate($user);
            $location->location = new Point($item[0], $item[1]);
            $locations->push($route->locations()->save($location));
        }
        broadcast(new RouteLocationUpdated($route, $locations));
    }
}
