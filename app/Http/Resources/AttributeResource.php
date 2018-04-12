<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class AttributeResource extends ApiResource
{
    protected function getComplexFields(Request $request): array
    {
        return [
            'type' => (new TypeResource($this->type))->toArray($request),
            'data' => $this->getData()
        ];
    }

    protected function getStructure(): array
    {
        return config('models.attribute_response');
    }
}
