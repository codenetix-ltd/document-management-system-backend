<?php

namespace App\Http\Resources;

use App\Entities\Permission;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PermissionResource
 * @package App\Http\Resources
 *
 * @property Permission $resource
 */
class PermissionResource extends JsonResource
{
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
