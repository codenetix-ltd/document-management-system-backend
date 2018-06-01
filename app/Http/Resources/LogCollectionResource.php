<?php

namespace App\Http\Resources;

class LogCollectionResource extends AbstractCollectionResource
{
    /**
     * @param $item
     * @return LogResource|mixed
     */
    protected function transformSingle($item)
    {
        return new LogResource($item);
    }
}
