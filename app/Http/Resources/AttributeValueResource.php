<?php

namespace App\Http\Resources;

use App\Entities\AttributeValue;
use App\Services\AttributeTypeCaster;

/**
 * @property AttributeValue $resource
 */
class AttributeValueResource extends AbstractSingularResource
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
            'id' => $this->resource->attribute->id,
            'type' => $this->resource->attribute->type->machineName,
            'value' => AttributeTypeCaster::getValue($this->resource)
        ];
    }
}
