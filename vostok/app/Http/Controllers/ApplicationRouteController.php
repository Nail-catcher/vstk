<?php

namespace App\Http\Controllers;

use App\Actions\Routes\CreateNewRoute;
use App\Events\RouteUpdated;
use App\Http\Requests\ApplicationRouteStore;
use App\Http\Resources\RouteResource;
use App\Models\Application;
use App\Models\Route;

class ApplicationRouteController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Route $route
     * @return RouteResource
     */
    public function store(ApplicationRouteStore $request, Route $route)
    {
        $input = $request->validated();
        $route->applications()->attach($input['application']);
        $route = (new CreateNewRoute())->expenses($route, $route->area);
        broadcast(new RouteUpdated($route))->toOthers();
        $route->save();
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
        $route = (new CreateNewRoute())->expenses($route, $route->area);
        broadcast(new RouteUpdated($route))->toOthers();
        $route->save();
        return redirect()->route('route.show', $route);
    }
}
