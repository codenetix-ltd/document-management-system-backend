<?php

namespace App\Http\Resources;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class TemplateCollectionResource extends AbstractCollectionResource
{
    protected function transformSingle($item)
    {
        return new TemplateResource($item);
    }
}
