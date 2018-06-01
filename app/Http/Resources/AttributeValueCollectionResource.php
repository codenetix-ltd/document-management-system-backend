<?php

namespace App\Http\Resources;

class AttributeValueCollectionResource extends AbstractCollectionResource
{
    /**
     * @param $item
     * @return AttributeValueResource|mixed
     */
    protected function transformSingle($item)
    {
        return new AttributeValueResource($item);
    }
}
