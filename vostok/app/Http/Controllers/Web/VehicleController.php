<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleFilter;
use App\Http\Resources\VehiclesResource;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return VehiclesResource
     */
    public function __invoke(VehicleFilter $request): VehiclesResource
    {
        return new VehiclesResource(Vehicle::filter($request->validated())->get());
    }
}
