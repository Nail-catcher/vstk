<?php

namespace App\Http\Controllers;

use App\Actions\Routes\UpdateRoute;
use App\Http\Requests\RouteClosed;
use App\Models\Route;

class RouteClosedController extends Controller
{
    public function store(RouteClosed $request, Route $route): \Illuminate\Http\RedirectResponse
    {
        (new UpdateRoute())->closed($route, $request->validated());
        return redirect()->back();
    }
}
