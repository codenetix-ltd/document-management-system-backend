<?php

namespace App\Http\Resources;

use App\Services\Attribute\AttributeTransactionService;
use Illuminate\Http\Request;

class TemplateResource extends BaseResource
{
    protected function getData(Request $request): array
    {
        $attributeTransactionService = app()->make(AttributeTransactionService::class);

        return [
            'id' => $this->name,
            'name' => $this->name,
            'attributes' => AttributeResource::collection($attributeTransactionService->list($this->resource->getId()))->toArray($request)
        ];
    }

    protected function getStructure(): array
    {
        return config('models.Template');
    }
}
