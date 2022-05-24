<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationReportResource extends JsonResource
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
            'application_id' => $this->application_id,
            'engineer' => new UserResource($this->whenLoaded('engineer')),
            'comment' => $this->comment,
            'created_at' => $this->created_at,
            'works' => new WorksResource($this->whenLoaded('works')),
            'images' => new ImagesResource($this->whenLoaded('images')),

        ];

    }
}
