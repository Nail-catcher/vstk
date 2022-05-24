<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InventoriesResource;
use Illuminate\Http\Request;

class MyInventoryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return InventoriesResource
     */
    public function __invoke(Request $request)
    {
        return new InventoriesResource($request->user()->inventories()->wherePivotNull('installed_at')->get());
    }
}
