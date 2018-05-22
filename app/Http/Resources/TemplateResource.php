<?php

namespace App\Http\Resources;

use App\Services\Attribute\AttributeTransactionService;
use Illuminate\Http\Resources\Json\Resource;

class TemplateResource extends Resource
{
    public function toArray($request)
    {
        //$attributeTransactionService = app()->make(AttributeTransactionService::class);

        return [
            'id' => $this->id,
            'name' => $this->name,
            //'attributes' => AttributeResource::collection($attributeTransactionService->list($this->resource->getId()))->toArray($request),
            'createdAt' => $this->created_at->timestamp,
            'updatedAt' => $this->updated_at->timestamp
        ];
    }
}
