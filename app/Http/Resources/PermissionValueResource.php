<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionValueResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource->pivot->permissionId,
            'accessType' => (new AccessTypeResource($this->resource->pivot->accessType))->toArray($request),
            'qualifiers' => QualifierPivotResource::collection($this->resource->pivot->qualifiers)->toArray($request)
        ];
    }
}
