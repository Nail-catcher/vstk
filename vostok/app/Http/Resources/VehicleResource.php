<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
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
            'title' => $this->title,
            'number' => $this->number,
            'area' => new AreaResource($this->whenLoaded('area')),
            'division' => new DivisionResource($this->whenLoaded('division')),
            'basic' => $this->basic,
            'winter' => $this->winter,
            'summer' => $this->summer,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}
