<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QualifierPivotResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'accessType' => (new AccessTypeResource($this->resource->pivot->accessType))->toArray($request)
        ];
    }
}
