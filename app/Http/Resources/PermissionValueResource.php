<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class PermissionValueResource extends ApiResource
{
    protected function getComplexFields(Request $request): array
    {
        return [
            'id' => $this->resource->pivot->permission_id,
            'accessType' => (new AccessTypeResource($this->resource->pivot->accessType))->toArray($request),
            'qualifiers' => QualifierResource::collection($this->resource->pivot->qualifiers)->toArray($request)
        ];
    }

    protected function getStructure(): array
    {
        return config('models.PermissionValue');
    }


}
