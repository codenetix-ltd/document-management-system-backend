<?php

namespace App\Http\Resources;

use App\Entities\Qualifier;

/**
 * Class QualifierPivotResource
 * @package App\Http\Resources
 *
 * @property Qualifier $resource
 */
class QualifierPivotResource extends AbstractSingularResource
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
            'accessType' => (new AccessTypeResource($this->resource->pivot->accessType))->toArray($request)
        ];
    }
}
