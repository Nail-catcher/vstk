<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AreaResource extends JsonResource
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
            'address' => $this->address,
            'location' => [
                'latitude' => $this->location->getLat(),
                'longitude' => $this->location->getLng(),
            ],
            'division' => $this->division,
            'applications' => new ApplicationsResource($this->whenLoaded('applications')),
            'applications_count' => $this->when($this->applications_count, $this->applications_count)
        ];
    }
}
