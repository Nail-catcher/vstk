<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProtocolResource extends JsonResource
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
            'starting' => new StartingResource($this->whenLoaded('starting')),
            'group' => new GroupResource($this->whenLoaded('group')),
            'battery' => new BatteryResource($this->whenLoaded('battery')),
            'type' => $this->type,
            'serial_number' => $this->serial_number,
            'rated_capacity' => $this->rated_capacity,
            'rated_voltage' => $this->rated_voltage,
            'rated_number' => $this->rated_number,
            'capacity' => $this->capacity,
            'allowable_capacity' => $this->allowable_capacity,
            'discharge_time_0' => $this->discharge_time_0,
            'discharge_time_30' => $this->discharge_time_30,
            'discharge_time_60' => $this->discharge_time_60,
            'discharge_time_90' => $this->discharge_time_90,
            'discharge_time_120' => $this->discharge_time_120,
            'discharge_time_150' => $this->discharge_time_150,
            'discharge_time_180' => $this->discharge_time_180,
            'discharge_time_210' => $this->discharge_time_210,
            'discharge_time_240' => $this->discharge_time_240,
            'discharge_time_270' => $this->discharge_time_270,
            'discharge_time_300' => $this->discharge_time_300,
            'discharge_time_330' => $this->discharge_time_330,
            'discharge_time_360' => $this->discharge_time_360,
            'discharge_time_390' => $this->discharge_time_390,
            'discharge_time_420' => $this->discharge_time_420,
            'discharge_time_450' => $this->discharge_time_450,
            'discharge_time_480' => $this->discharge_time_480,
            'device' => $this->device
        ];
    }
}
