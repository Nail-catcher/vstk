<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProgressTypeResource;
use App\Http\Resources\ProgressTypesResource;
use App\Models\ProgressType;
use Illuminate\Http\Request;

class ProgressTypeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return ProgressTypesResource
     */
    public function index(Request $request): ProgressTypesResource
    {
        return new ProgressTypesResource(ProgressType::all(['id', 'title']));
    }

    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param ProgressType $type
     * @return ProgressTypeResource
     */
    public function show(Request $request, ProgressType $type): ProgressTypeResource
    {
        return new ProgressTypeResource($type->load('progresses'));
    }
}
