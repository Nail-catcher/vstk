<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DefectiveResource extends JsonResource
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
            'starting' => new StartingResource($this->whenLoaded('starting')),
            'title' => $this->title,
            'serial_number' => $this->serial_number,
            'inventory_number' => $this->inventory_number,
            'quantity' => $this->quantity,
            'comment' => $this->comment,
            'barcode' => $this->barcode,
            'barcode_type' => $this->barcode_type
        ];
    }
}
