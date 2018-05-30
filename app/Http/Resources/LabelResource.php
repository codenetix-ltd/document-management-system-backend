<?php

namespace App\Http\Resources;

use App\Entities\Label;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class LabelResource
 * @package App\Http\Resources
 *
 * @property Label $resource
 */
class LabelResource extends JsonResource
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
            'updatedAt' => $this->resource->updatedAt->timestamp
        ];
    }
}
