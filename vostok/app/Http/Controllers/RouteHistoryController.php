<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoutesResource;
use App\Models\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RouteHistoryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function __invoke(Request $request)
    {
        $routes = Route::with(['activity', 'user', 'applications', 'applications.stations', 'area', 'division',])
            ->withCount('applications')
            ->inactive()
            ->latest('id');
        return Inertia::render('Routes/History', [

            'routes' => new RoutesResource($routes->paginate())
        ]);
    }
}
