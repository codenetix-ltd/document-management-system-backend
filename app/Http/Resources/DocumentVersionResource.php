<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class DocumentVersionResource extends ApiResource
{

    protected function getComplexFields(Request $request): array
    {
        return [
            'labelIds' => $this->tags->pluck('id'),
            'labels' => (new ArrayResource($this->tags, TagResource::class))->toArray($request),
            'attributeValues' => (new ArrayResource($this->attributeValues, AttributeValueResource::class))->toArray($request),
        ];
    }

    protected function getStructure(): array
    {
        return config('models.DocumentVersion');
    }
}
