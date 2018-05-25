<?php

namespace App\Http\Resources;

use App\Entities\Type;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class TypeResource
 * @package App\Http\Resources
 *
 * @property Type $resource
 */
class TypeResource extends JsonResource
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
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'machineName' => $this->resource->machineName,
            'createdAt' => $this->resource->createdAt->timestamp,
            'updatedAt' => $this->resource->updatedAt->timestamp
        ];
    }
}
