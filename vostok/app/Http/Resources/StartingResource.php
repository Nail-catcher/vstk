<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StartingResource extends JsonResource
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
            'type' => new ProgressTypeResource($this->whenLoaded('type')),
            'user' => new UserResource($this->whenLoaded('user')),
            'station' => new StationResource($this->whenLoaded('station')),
            'progresses' => new ProgressesResource($this->whenLoaded('progresses')),
            'protocols' => new ProtocolsResource($this->whenLoaded('protocols')),
            'created_at' => $this->created_at
        ];
    }
}
