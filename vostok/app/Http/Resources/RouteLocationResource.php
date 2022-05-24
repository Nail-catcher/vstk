<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RouteLocationResource extends JsonResource
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
            'route' => new RouteResource($this->whenLoaded('route')),
            'user' => new UserResource($this->whenLoaded('user')),
            'location' => [
                'latitude' => $this->location->getLat(),
                'longitude' => $this->location->getLng()
            ],
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}
