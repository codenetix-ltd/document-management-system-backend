<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class DocumentResource extends ApiResource
{
    protected function getComplexFields(Request $request): array
    {
        return [
            'actualVersion' => (new DocumentVersionResource($this->actualVersion))->toArray($request),
        ];
    }

    protected function getStructure(): array
    {
        return config('models.Document');
    }
}
