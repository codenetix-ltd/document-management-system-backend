<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class AttributeResource extends BaseResource
{
    protected function getData(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => (new TypeResource($this->type))->toArray($request),
            'name' => $this->name,
            'data' => $this->resource->getData()
        ];
    }

    protected function getStructure(): array
    {
        return config('models.Attribute');
    }
}
