<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoutesResource;
use App\Models\Route;
use Illuminate\Http\Request;

class RouteHistoryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return RoutesResource
     */
    public function __invoke(Request $request): RoutesResource
    {
        $routes = Route::with(['user', 'applications', 'applications.stations', 'area', 'division', 'activity'])
            ->withCount('applications')
            ->inactive()
            ->latest('id');
        return new RoutesResource($routes->paginate());
    }
}
