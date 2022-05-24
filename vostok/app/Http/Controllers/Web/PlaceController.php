<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlaceFilterRequest;
use App\Http\Resources\PlacesResource;
use App\Models\Place;

class PlaceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return PlacesResource
     */
    public function __invoke(PlaceFilterRequest $request): PlacesResource
    {
        return new PlacesResource(Place::filter($request->validated())->get());
    }
}
