<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StationResource extends JsonResource
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
            'user' => new UserResource($this->whenLoaded('user')),
            'area' => new AreaResource($this->whenLoaded('area')),
            'division' => new DivisionResource($this->whenLoaded('division')),
            'state' => new StateResource($this->whenLoaded('state')),
            'region' => new RegionResource($this->whenLoaded('region')),
            'city' => new CityResource($this->whenLoaded('city')),
            'bts_id' => $this->bts_id,
            'title' => $this->title,
            'rac' => $this->rac,
            'base_station_type' => $this->base_station_type,
            'type_steel_structure' => $this->type_steel_structure,
            'location' => [
                'latitude' => $this->location->getLat(),
                'longitude' => $this->location->getLng(),
                'distance' => $this->when($this->distance, $this->distance),
            ],
            'is_complete' => $this->whenPivotLoaded('application_station', function () {
                return (bool)$this->pivot->is_complete;
            }),
            'is_active' => $this->whenPivotLoaded('application_station', function () {
                return (bool)$this->pivot->is_active;
            }),
            'supply' => $this->supply,
            'distance' => $this->distance,
            'prop_height' => $this->prop_height,
            'prop_type' => $this->prop_type,
            'antenna_suspension_height_a' => $this->antenna_suspension_height_a,
            'antenna_suspension_height_b' => $this->antenna_suspension_height_b,
            'antenna_suspension_height_c' => $this->antenna_suspension_height_c,
            'antenna_azimuths_tilt_angle_a' => $this->antenna_azimuths_tilt_angle_a,
            'antenna_azimuths_tilt_angle_b' => $this->antenna_azimuths_tilt_angle_b,
            'antenna_azimuths_tilt_angle_c' => $this->antenna_azimuths_tilt_angle_c,
            'equipment_installation_location' => $this->equipment_installation_location,
            'antenna_installation_location' => $this->antenna_installation_location,
            'guaranteed_power' => $this->guaranteed_power,
            'stand_type' => $this->stand_type,
            'rectifier_units_type' => $this->rectifier_units_type,
            'number_rectifier_units' => $this->number_rectifier_units,
            'battery_capacity' => $this->battery_capacity,
            'battery_count' => $this->battery_count,
            'priority' => $this->priority,
            'order_number' => $this->order_number,
            'order_additional' => $this->order_additional,
            'subcon' => $this->subcon,
            'comment' => $this->comment,
            'groups' => new GroupsResource($this->whenLoaded('groups')),
            'applications' => new ApplicationsResource($this->whenLoaded('applications')),
            'applications_count' => $this->when(isset($this->applications_count), $this->applications_count),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}
