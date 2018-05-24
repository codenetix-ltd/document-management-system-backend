<?php

namespace App\Http\Resources;

class DocumentVersionCollectionResource extends AbstractCollectionResource
{
    protected function transformSingle($item)
    {
        return new DocumentVersionResource($item);
    }
}
