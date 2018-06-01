<?php

namespace App\Http\Resources;

class DocumentVersionCollectionResource extends AbstractCollectionResource
{
    /**
     * @param $item
     * @return DocumentVersionResource|mixed
     */
    protected function transformSingle($item)
    {
        return new DocumentVersionResource($item);
    }
}
