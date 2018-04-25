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
//            'type' => (new TypeResource($this->type))->toArray($request),
//            'table' => $this->getData()
        ];
    }

    protected function getStructure(): array
    {
        return config('models.DocumentVersion');
    }
}
