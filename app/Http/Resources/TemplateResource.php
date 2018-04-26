<?php

namespace App\Http\Resources;

use App\Services\Attribute\AttributeTransactionService;
use Illuminate\Http\Request;

class TemplateResource extends ApiResource
{
    protected function getComplexFields(Request $request): array
    {
        $attributeTransactionService = app()->make(AttributeTransactionService::class);

        return [
            'attributes' => AttributeResource::collection($attributeTransactionService->list($this->resource->getId()))->toArray($request)
        ];
    }

    protected function getStructure(): array
    {
        return config('models.Template');
    }
}
