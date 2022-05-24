<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'application' => new ApplicationResource($this->whenLoaded('application')),
            'user' => new UserResource($this->whenLoaded('user')),
            'comment' => $this->comment,
            'created_at' => $this->created_at,
        ];
    }
}
