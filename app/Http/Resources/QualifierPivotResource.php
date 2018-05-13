<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class QualifierPivotResource extends QualifierResource
{
    protected function getStructure(): array
    {
        return config('models.Qualifier');
    }

    protected function getData(Request $request): array
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'accessType' => (new AccessTypeResource($this->resource->pivot->accessType))->toArray($request)
        ];
    }
}
