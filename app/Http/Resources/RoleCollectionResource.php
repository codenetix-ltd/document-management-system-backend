<?php

namespace App\Http\Resources;

class RoleCollectionResource extends AbstractCollectionResource
{
    /**
     * @param $item
     * @return RoleResource|mixed
     */
    protected function transformSingle($item)
    {
        return new RoleResource($item);
    }
}
