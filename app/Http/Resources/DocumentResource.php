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
            'actualVersion' => (new DocumentVersionResource($this->documentActualVersion))->toArray($request),
            'owner' => (new UserResource($this->owner))->toArray($request),
            'version' => (int)($this->documentActualVersion->getVersionName())
        ];
    }

    protected function getStructure(): array
    {
        return config('models.Document');
    }
}
