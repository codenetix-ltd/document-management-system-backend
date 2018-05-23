<?php

namespace App\Http\Resources;

class LabelCollectionResource extends AbstractCollectionResource
{
    protected function transformSingle($item)
    {
        return new LabelResource($item);
    }
}
