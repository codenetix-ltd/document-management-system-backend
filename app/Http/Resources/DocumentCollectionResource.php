<?php

namespace App\Http\Resources;

class DocumentCollectionResource extends AbstractCollectionResource
{
    /**
     * @param $item
     * @return DocumentResource|mixed
     */
    protected function transformSingle($item)
    {
        return new DocumentResource($item);
    }
}
