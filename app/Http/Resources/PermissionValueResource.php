<?php

namespace App\Http\Resources;

class PermissionValueResource extends AbstractSingularResource
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
            'id' => $this->resource->pivot->permission_id,
            'accessType' => (new AccessTypeResource($this->resource->pivot->accessType))->toArray($request),
            'qualifiers' => QualifierPivotResource::collection($this->resource->pivot->qualifiers)->toArray($request)
        ];
    }
}
