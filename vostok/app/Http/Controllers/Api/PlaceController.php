<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlaceFilterRequest;
use App\Http\Resources\PlacesResource;
use App\Models\Place;
use Illuminate\Support\Facades\Auth;

class PlaceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param PlaceFilterRequest $request
     * @return PlacesResource
     */
    public function __invoke(PlaceFilterRequest $request): PlacesResource
    {
        $input = $request->validated();
        $user = Auth::user();
        if (!isset($input['division'])) {
            $input['division'] = $user->division_id;
        }
        return new PlacesResource(Place::filter($input)->paginate());
    }
}
