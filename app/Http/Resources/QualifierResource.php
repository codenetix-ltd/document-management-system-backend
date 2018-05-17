<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QualifierResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'accessType' => AccessTypeResource::collection($this->accessTypes)->toArray($request)
        ];
    }
}
