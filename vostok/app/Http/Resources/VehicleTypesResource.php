<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class VehicleTypesResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return VehicleTypeResource::collection($this->collection);
    }
}
