<?php

namespace App\Http\Resources;

class DocumentCollectionResource extends AbstractCollectionResource
{
    protected function transformSingle($item)
    {
        return new DocumentResource($item);
    }
}
