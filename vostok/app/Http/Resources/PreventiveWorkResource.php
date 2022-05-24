<?php

namespace App\Http\Resources;

use App\Models\Group;
use App\Models\Sensor;
use Illuminate\Http\Resources\Json\JsonResource;

class PreventiveWorkResource extends JsonResource
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
            'modelable' => $this->whenLoaded('modelable', function () {
                if ($this->modelable instanceof Group) {
                    return new GroupResource($this->modelable);
                }
                if ($this->modelable instanceof Sensor) {
                    return new SensorResource($this->modelable);
                }
                return null;
            }),
            'value' => $this->value,
            'deviation' => $this->deviation,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}
