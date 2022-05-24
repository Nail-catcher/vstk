<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConsumableFilterRequest;
use App\Http\Resources\ConsumablesResource;
use App\Models\Consumable;

class ConsumableController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param ConsumableFilterRequest $request
     * @return ConsumablesResource
     */
    public function __invoke(ConsumableFilterRequest $request): ConsumablesResource
    {
        $input = $request->validated();
        return new ConsumablesResource(Consumable::filter($input)->get());
    }
}
