<?php

namespace App\Http\Resources;

use App\Entities\AttributeValue;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property AttributeValue $resource
 */
class AttributeValueResource extends JsonResource
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
            'value' => $this->resource->value
        ];
    }
}
