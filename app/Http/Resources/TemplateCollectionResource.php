<?php

namespace App\Http\Resources;

class TemplateCollectionResource extends AbstractCollectionResource
{
    /**
     * @param $item
     * @return TemplateResource|mixed
     */
    protected function transformSingle($item)
    {
        return new TemplateResource($item);
    }
}
