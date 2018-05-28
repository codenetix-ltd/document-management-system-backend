<?php

namespace App\Http\Resources;

use App\Entities\Qualifier;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class QualifierResource
 * @package App\Http\Resources
 *
 * @property Qualifier $resource
 */
class QualifierResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'label' => $this->resource->label,
            'accessType' => AccessTypeResource::collection($this->resource->accessTypes)->toArray($request)
        ];
    }
}
