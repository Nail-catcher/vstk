<?php

namespace App\Http\Controllers\Api;

use App\Actions\Routes\CreateNewRoute;
use App\Actions\Routes\UpdateRoute;
use App\Http\Controllers\Controller;
use App\Http\Requests\RouteFilter;
use App\Http\Requests\RouteStore;
use App\Http\Requests\RouteUpdate;
use App\Http\Resources\RouteResource;
use App\Http\Resources\RoutesResource;
use App\Models\Route;
use Illuminate\Support\Facades\Auth;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param RouteFilter $request
     * @return RoutesResource
     */
    public function index(RouteFilter $request): RoutesResource
    {
        $data = $request->validated();
        $user = Auth::user();
        $routes = Route::with([
            'activity',
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
        ])
            ->active()
            ->latest('id');
        if ($user->hasRole('engineer')) {
            $routes->where(function ($query) {
                $query->whereHas('users', function ($query) {
                    $query->where('id', '=', Auth::id());
                })
                    ->orWhere('engineer_id', '=', Auth::id());
            });
        }
        return new RoutesResource($routes->paginate($data['limit'] ?? null)->appends($data));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return RouteResource
     */
    public function store(RouteStore $request): RouteResource
    {
        $route = (new CreateNewRoute())->create($request->validated());
        return new RouteResource(
            $route->load([
                'activity',
                'applications',
                'applications.type',
                'applications.work',
                'applications.works',
                'applications.stations',
                'applications.status',
            ])
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Route $route
     * @return RouteResource
     */
    public function show(Route $route): RouteResource
    {
        return new RouteResource(
            $route->load([

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
            ])
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Route $route
     * @return RouteResource
     */
    public function update(RouteUpdate $request, Route $route): RouteResource
    {
        $route->load([
            'activity',
            'applications',
            'applications.type',
            'applications.work',
            'applications.works',
            'applications.stations',
            'applications.status',
        ]);
        $route = (new UpdateRoute())->update($route, $request->validated());
        return new RouteResource($route);
    }
}
