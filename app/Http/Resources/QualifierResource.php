<?php

namespace App\Http\Resources;

use App\Entities\Qualifier;

/**
 * Class QualifierResource
 * @package App\Http\Resources
 *
 * @property Qualifier $resource
 */
class QualifierResource extends AbstractSingularResource
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
            'accessType' => AccessTypeResource::collection($this->resource->accessTypes)->toArray($request)
        ];
    }
}
