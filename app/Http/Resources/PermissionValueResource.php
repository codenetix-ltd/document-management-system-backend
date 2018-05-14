<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class PermissionValueResource extends BaseResource
{
    protected function getStructure(): array
    {
        return config('models.PermissionValue');
    }

    protected function getData(Request $request): array
    {
        return [
            'id' => $this->resource->pivot->permission_id,
            'accessType' => (new AccessTypeResource($this->resource->pivot->accessType))->toArray($request),
            'qualifiers' => QualifierPivotResource::collection($this->resource->pivot->qualifiers)->toArray($request)
        ];
    }


}
