<?php

namespace App\Http\Resources;

use App\Entities\Label;
use App\Facades\AuthPermissions;

/**
 * Class LabelResource
 * @package App\Http\Resources
 *
 * @property Label $resource
 */
class LabelResource extends AbstractSingularResource
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
            'createdAt' => $this->resource->createdAt->timestamp,
            'updatedAt' => $this->resource->updatedAt->timestamp,
            'authPermissions' => AuthPermissions::getList('label', $this->resource)
        ];
    }
}
