<?php

namespace App\Http\Resources;

class LabelCollectionResource extends AbstractCollectionResource
{
    /**
     * @param $item
     * @return LabelResource|mixed
     */
    protected function transformSingle($item)
    {
        return new LabelResource($item);
    }
}
