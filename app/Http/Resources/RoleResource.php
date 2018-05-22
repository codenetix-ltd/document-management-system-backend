<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'templateIds' => $this->templates->pluck('id')->toArray(),
            'permissionValues' => PermissionValueResource::collection($this->permissions)->toArray($request),
            'createdAt' => $this->createdAt->timestamp,
            'updatedAt' => $this->updatedAt->timestamp
        ];
    }
}
