<?php

namespace App\Http\Resources;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class FileCollectionResource extends AbstractCollectionResource
{
    protected function transformSingle($item)
    {
        return new FileResource($item);
    }
}
