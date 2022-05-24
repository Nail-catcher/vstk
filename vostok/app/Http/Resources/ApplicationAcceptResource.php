<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationAcceptResource extends JsonResource
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
            'comment' => $this->comment,
            'user' => new UserResource($this->whenLoaded('user')),
            'users' => new UsersResource($this->whenLoaded('users')),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}
