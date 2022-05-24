<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StatusResource extends JsonResource
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
            'icon' => $this->icon,
            'pivot' => $this->whenPivotLoaded('application_status', function () {
                return [
                    'comment' => $this->pivot->comment,
                    'user' => new UserResource($this->pivot->user),
                    'old_status' => new StatusResource($this->pivot->old_status),
                    'created_at' => $this->pivot->created_at
                ];
            }),
        ];
    }
}
