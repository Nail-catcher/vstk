<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'lastname' => $this->lastname,
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'email' => $this->email,
            'phone' => $this->phone,
            'division' => new DivisionResource($this->whenLoaded('division')),
            'position' => new PositionResource($this->whenLoaded('position')),
            'status' => new StatusResource($this->whenLoaded('status')),
            'roles' => new RolesResource($this->whenLoaded('roles')),
            'permissions' => new PermissionsResource($this->whenLoaded('roles', $this->getPermissions())),
            'inventories' => new InventoriesResource($this->whenLoaded('inventories')),
            'applications_count' => $this->when($this->applications_count, $this->applications_count),
            'profile_photo_url' => $this->when($this->profile_photo_path, $this->profile_photo_url),
        ];
    }
}
