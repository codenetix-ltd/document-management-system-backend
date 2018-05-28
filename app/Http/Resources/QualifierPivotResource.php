<?php

namespace App\Http\Resources;

use App\Entities\Qualifier;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class QualifierPivotResource
 * @package App\Http\Resources
 *
 * @property Qualifier $resource
 */
class QualifierPivotResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'label' => $this->resource->label,
            'accessType' => (new AccessTypeResource($this->resource->pivot->accessType))->toArray($request)
        ];
    }
}
