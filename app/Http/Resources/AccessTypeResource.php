<?php

namespace App\Http\Resources;

use App\Entities\AccessType;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class AccessTypeResource
 * @package App\Http\Resources
 * @property AccessType $resource
 */
class AccessTypeResource extends JsonResource
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
            'label' => $this->resource->label,
            'createdAt' => $this->resource->createdAt->timestamp,
            'updatedAt' => $this->resource->updatedAt->timestamp
        ];
    }
}
