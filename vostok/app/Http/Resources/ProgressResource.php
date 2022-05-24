<?php

namespace App\Http\Resources;

use App\Models\PreventiveWork;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgressResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->progress_id,
            'title' => $this->whenLoaded('progress', $this->progress->title),
            'typeable' => $this->whenLoaded('typeable', function () {
                if ($this->typeable instanceof PreventiveWork) {
                    return new PreventiveWorkResource($this->typeable);
                }
            }),
            'inventories' => new InventoriesResource($this->whenLoaded('inventories')),
            'images' => new ImagesResource($this->whenLoaded('images')),
            'works' => new WorksResource($this->whenLoaded('works')),
            'comment' => $this->comment,
            'created_at' => $this->created_at
        ];
    }
}
