<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DivisionResource extends JsonResource
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
            'user' => new UserResource($this->whenLoaded('user')),
            'applications_count' => $this->when($this->applications_count, $this->applications_count)
        ];
    }
}
