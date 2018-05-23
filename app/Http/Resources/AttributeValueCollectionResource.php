<?php

namespace App\Http\Resources;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class AttributeValueCollectionResource extends AbstractCollectionResource
{
    protected function transformSingle($item)
    {
        return new AttributeValueResource($item);
    }
}
