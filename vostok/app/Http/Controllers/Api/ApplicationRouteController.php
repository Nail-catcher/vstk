<?php

namespace App\Http\Controllers\Api;

use App\Events\RouteUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationRouteStore;
use App\Models\Application;
use App\Models\Route;

class ApplicationRouteController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Route $route
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ApplicationRouteStore $request, Route $route): \Illuminate\Http\RedirectResponse
    {
        $input = $request->validated();
        $route->applications()->attach($input['application']);
        $route->distance = $route->applications()->sum('distance');
        $route->save();
        broadcast(new RouteUpdated($route))->toOthers();
        return redirect()->route('route.show', $route);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Route $route
     * @param Application $application
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Route $route, Application $application): \Illuminate\Http\RedirectResponse
    {
        $route->applications()->detach($application);
        $route->distance = $route->applications()->sum('distance');
        $route->save();
        broadcast(new RouteUpdated($route))->toOthers();
        return redirect()->route('route.show', $route);
    }
}
