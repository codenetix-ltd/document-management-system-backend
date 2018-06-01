<?php

namespace App\Http\Resources;

class FileCollectionResource extends AbstractCollectionResource
{
    /**
     * @param $item
     * @return FileResource|mixed
     */
    protected function transformSingle($item)
    {
        return new FileResource($item);
    }
}
