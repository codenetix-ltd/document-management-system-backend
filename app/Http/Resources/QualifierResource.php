<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class QualifierResource extends BaseResource
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
            'accessType' => AccessTypeResource::collection($this->accessTypes)->toArray($request)
        ];
    }
}
