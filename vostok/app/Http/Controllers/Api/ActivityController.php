<?php

namespace App\Http\Controllers\Api;

use App\Actions\Routes\UpdateRoute;
use App\Http\Controllers\Controller;
use App\Http\Requests\RouteClosed;
use App\Http\Resources\RouteResource;
use App\Jobs\RouteLocationsDistance;
use App\Models\Activity;
use App\Models\Route;
use App\Notifications\RouteCompleted;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * @param Request $request
     * @param Route $route
     * @return RouteResource
     */
    public function active(Request $request, Route $route): RouteResource
    {
        $route->activity()->associate(Activity::ACTIVE);
        $route->save();
        //return new RouteResource($route->load(['activity','applications']));
        return new RouteResource($route->load([
            'area',
            'addresses',
            'places',
            'activity',
            'vehicle_type',
            'vehicle',
            'engineer',
            'users',
            'applications',
            'applications.type',
            'applications.work',
            'applications.works',
            'applications.stations',
            'applications.status',
            'applications.startings',
            'applications.startings.station:id,bts_id,location',
            'applications.startings.progresses',
            'applications.startings.progresses.progress',
        ]));
    }

    /**
     * @param Request $request
     * @param Route $route
     * @return RouteResource
     */
    public function pause(Request $request, Route $route): RouteResource
    {
        $route->activity()->associate(Activity::PAUSE);
        $route->save();
        $this->dispatch(new RouteLocationsDistance($route));
        //return new RouteResource($route->load(['activity','applications']));
        return new RouteResource($route->load([
            'area',
            'addresses',
            'places',
            'activity',
            'vehicle_type',
            'vehicle',
            'engineer',
            'users',
            'applications',
            'applications.type',
            'applications.work',
            'applications.works',
            'applications.stations',
            'applications.status',
            'applications.startings',
            'applications.startings.station:id,bts_id,location',
            'applications.startings.progresses',
            'applications.startings.progresses.progress',
        ]));
    }

    /**
     * @param Request $request
     * @param Route $route
     * @return RouteResource
     */
    public function completed(Request $request, Route $route): RouteResource
    {
        $route->activity()->associate(Activity::COMPLETED);
        $route->save();
        $route->user->notify(new RouteCompleted($route, $route->engineer));
        $this->dispatch(new RouteLocationsDistance($route));
        //return new RouteResource($route->load(['activity','applications']));
        return new RouteResource($route->load([
            'area',
            'addresses',
            'places',
            'activity',
            'vehicle_type',
            'vehicle',
            'engineer',
            'users',
            'applications',
            'applications.type',
            'applications.work',
            'applications.works',
            'applications.stations',
            'applications.status',
            'applications.startings',
            'applications.startings.station:id,bts_id,location',
            'applications.startings.progresses',
            'applications.startings.progresses.progress',
        ]));
    }

    /**
     * @param RouteClosed $request
     * @param Route $route
     * @return RouteResource
     */
    public function closed(RouteClosed $request, Route $route): RouteResource
    {
        $route = (new UpdateRoute())->closed($route, $request->validated());
        $this->dispatch(new RouteLocationsDistance($route));
        //return new RouteResource($route->load(['activity','applications']));
        return new RouteResource($route->load([
            'area',
            'addresses',
            'places',
            'activity',
            'vehicle_type',
            'vehicle',
            'engineer',
            'users',
            'applications',
            'applications.type',
            'applications.work',
            'applications.works',
            'applications.stations',
            'applications.status',
            'applications.startings',
            'applications.startings.station:id,bts_id,location',
            'applications.startings.progresses',
            'applications.startings.progresses.progress',
        ]));
    }
}
