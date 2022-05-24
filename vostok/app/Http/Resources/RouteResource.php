<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RouteResource extends JsonResource
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
            'title'=>$this->id,
            'user' => new UserResource($this->whenLoaded('user')),
            'division' => new DivisionResource($this->whenLoaded('division')),
            'area' => new AreaResource($this->whenLoaded('area')),
            'activity' => new ActivityResource($this->whenLoaded('activity')),
            'locations' => new RouteLocationsResource($this->whenLoaded('locations')),
            'applications' => new ApplicationsResource($this->whenLoaded('applications')),
            'applications_count' => $this->when($this->applications_count, $this->applications_count),
            'addresses' => new AddressesResource($this->whenLoaded('addresses')),
            'places' => new PlacesResource($this->whenLoaded('places')),
            'vehicle_type'=> new VehicleTypeResource($this->whenLoaded('vehicle_type')),
            'vehicle'=> new VehicleResource($this->whenLoaded('vehicle')),
            'engineer'=>new UserResource($this->whenLoaded('engineer')),
            'users'=>new UsersResource($this->whenLoaded('users')),
            'order_document' => $this->order_document,
            'order_number' => $this->order_number,
            'distance' => $this->distance,
            'actual_distance' => $this->actual_distance,
            'fuel_costs' => $this->fuel_costsexpenses,
            'travel_costs' => $this->travel_costs,
            'material_costs' => $this->material_costs,
            'overnight_costs' => $this->overnight_costs,
            'expenses' => $this->expenses,
            'fuels' => $this->fuels,
            'started_at' => $this->started_at,
            'deadline_at' => $this->deadline_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
