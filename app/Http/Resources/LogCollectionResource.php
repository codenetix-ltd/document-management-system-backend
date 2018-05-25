<?php

namespace App\Http\Resources;

class LogCollectionResource extends AbstractCollectionResource
{
    protected function transformSingle($item)
    {
        return new LogResource($item);
    }
}
