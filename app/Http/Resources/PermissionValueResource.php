<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionValueResource extends JsonResource
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
            'id' => $this->resource->pivot->permissionId,
            'accessType' => (new AccessTypeResource($this->resource->pivot->accessType))->toArray($request),
            'qualifiers' => QualifierPivotResource::collection($this->resource->pivot->qualifiers)->toArray($request)
        ];
    }
}
