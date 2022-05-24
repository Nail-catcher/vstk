<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsumableResource extends JsonResource
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
            'unit' => new UnitResource($this->whenLoaded('unit')),
            'spm' => $this->spm,
            'atr' => $this->atr,
            'cost' => $this->cost
        ];
    }
}
