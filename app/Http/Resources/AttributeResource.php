<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class AttributeResource extends ApiResource
{
    protected function getComplexFields(Request $request): array
    {
        return [
            'type' => (new TypeResource($this->type))->toArray($request),
            'table' => $this->getData()
        ];
    }

    protected function getStructure(): array
    {
        return config('models.Attribute');
    }
}
