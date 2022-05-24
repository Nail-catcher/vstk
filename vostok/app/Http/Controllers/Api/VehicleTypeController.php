<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\VehicleTypesResource;
use App\Models\VehicleType;
class VehicleTypeController extends Controller
{
    public function __invoke(Request $request): VehicleTypesResource
    {
        return new VehicleTypesResource(VehicleType::all());
    }
}
