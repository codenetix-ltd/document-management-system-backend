<?php

namespace App\Http\Resources;

use App\Entities\Role;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class RoleResource
 * @package App\Http\Resources
 *
 * @property Role $resource
 */
class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'templateIds' => $this->resource->templates->pluck('id')->toArray(),
            'permissionValues' => PermissionValueResource::collection($this->resource->permissions)->toArray($request),
            'createdAt' => $this->resource->createdAt->timestamp,
            'updatedAt' => $this->resource->updatedAt->timestamp
        ];
    }
}
