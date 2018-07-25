<?php

namespace App\Http\Resources;

use App\Entities\PermissionGroup;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PermissionGroupResource
 * @package App\Http\Resources
 *
 * @property PermissionGroup $resource
 */
class PermissionGroupResource extends JsonResource
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
            'label' => $this->resource->label,
            'permissions' => PermissionResource::collection($this->resource->permissions)->toArray($request),
            'qualifiers' => QualifierResource::collection($this->resource->qualifiers)->toArray($request)
        ];
    }
}
