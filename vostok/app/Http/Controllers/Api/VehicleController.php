<?php

namespace App\Http\Controllers\Api;

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
        $input = $request->validated();
        if ($request->user()->hasRole('engineer')) {
            $input['division'] = $request->user()->division_id;
        }
        return new VehiclesResource(Vehicle::with('division', 'area')->filter($input)->paginate());
    }
}
