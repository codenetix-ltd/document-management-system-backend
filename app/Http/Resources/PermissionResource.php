<?php

namespace App\Http\Resources;

use App\Entities\Permission;

/**
 * Class PermissionResource
 * @property Permission $resource
 */
class PermissionResource extends AbstractSingularResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'label' => $this->resource->label,
            'accessTypes' => AccessTypeResource::collection($this->resource->accessTypes)->toArray($request)
        ];
    }
}
