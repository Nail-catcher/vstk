<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlaceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'division' => new DivisionResource($this->whenLoaded('division')),
            'title' => $this->title,
            'address' => $this->address,
            'location' => [
                'latitude' => $this->location->getLat(),
                'longitude' => $this->location->getLng()
            ],
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}
