<?php

namespace App\Http\Resources;

use App\Entities\AttributeValue;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 *
 * @property AttributeValue $resource
 */
class AttributeValueResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'type' => $this->resource->attribute->type->machineName,
            'value' => $this->resource->value
        ];
    }
}
