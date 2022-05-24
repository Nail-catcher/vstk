<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'division' => new DivisionResource($this->whenLoaded('division')),
            'state' => new StateResource($this->whenLoaded('state')),
            'region' => new RegionResource($this->whenLoaded('region')),
            'city' => new CityResource($this->whenLoaded('city')),
            'address' => $this->address,
            'cost' => $this->cost,
            'location' => [
                'latitude' => $this->location->getLat(),
                'longitude' => $this->location->getLng(),
            ],
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}
