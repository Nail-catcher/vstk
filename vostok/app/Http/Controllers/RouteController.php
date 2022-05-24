<?php

namespace App\Http\Controllers;

use App\Actions\Routes\CreateNewRoute;
use App\Actions\Routes\UpdateRoute;
use App\Http\Requests\RouteFilter;
use App\Http\Requests\RouteStore;
use App\Http\Requests\RouteUpdate;
use App\Http\Resources\RoutesResource;
use App\Models\Area;
use App\Models\Route;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Inertia\Inertia;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param RouteFilter $request
     * @return \Inertia\Response
     */
    public function index(RouteFilter $request): \Inertia\Response
    {
        $input = $request->validated();
        $routes = Route::with(['user', 'applications', 'users', 'applications.stations', 'area', 'division', 'activity'])
            ->withCount('applications')
            ->active()
            ->latest('id');
        $routes->filter($input);
        return Inertia::render('Routes/Index', [
            'areas' => Area::all(),
            'routes' => new RoutesResource($routes->paginate()->appends($input))
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('Routes/Create', [
            'vehicle_types' => VehicleType::all(),
            'vehicles' => Vehicle::all(),
            'areas' => Area::all(),
            'users' => User::where('position_id', '=', 1)->active()->orderBy('lastname')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RouteStore $request): \Illuminate\Http\RedirectResponse
    {
        $route = (new CreateNewRoute())->create($request->validated());
        return redirect()->route('route.show', $route);
    }

    /**
     * Display the specified resource.
     *
     * @param Route $route
     * @return \Inertia\Response
     */
    public function show(Route $route): \Inertia\Response
    {
        return Inertia::render('Routes/Show', [
            'route' => $route->load([
                'user',
                'addresses',
                'vehicle_type',
                'vehicle',
                'area',
                'engineer',
                'users',
                'activity',
                'closures',
                'applications',
                'applications.user',
                'applications.status',
                'applications.users',
                'applications.stations',
                'applications.type',
                'applications.work',
                'applications.project',
                'applications.works',
                'applications.routes',
                'exApplications',
                'exApplications.users',
                'exApplications.stations',
                'exApplications.type',
                'exApplications.work',
                'exApplications.works',
            ])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Route $route
     * @return \Illuminate\Http\Response
     */
    public function edit(Route $route)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Route $route
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RouteUpdate $request, Route $route): \Illuminate\Http\RedirectResponse
    {

        (new UpdateRoute())->update($route, $request->validated());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Route $route
     * @return \Illuminate\Http\Response
     */
    public function destroy(Route $route)
    {
        //
    }
}
