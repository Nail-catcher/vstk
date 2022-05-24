<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
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
            'rrs' => $this->rrs,
            'range' => $this->range,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'user' => new UserResource($this->whenLoaded('user')),
            'title' => $this->title,
            'manufacturer_code' => $this->manufacturer_code,
            'serial_number' => $this->serial_number,
            'barcode' => $this->barcode,
            'barcode_type' => $this->barcode_type,
        ];
    }
}
