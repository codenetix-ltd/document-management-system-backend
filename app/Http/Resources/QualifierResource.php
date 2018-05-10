<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class QualifierResource extends ApiResource
{
    protected function getComplexFields(Request $request): array
    {
        return [
            'accessTypes' => AccessTypeResource::collection($this->accessTypes)->toArray($request)
        ];
    }

    protected function getStructure(): array
    {
        return config('models.Qualifier');
    }
}
