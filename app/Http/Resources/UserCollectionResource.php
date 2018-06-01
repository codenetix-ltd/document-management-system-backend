<?php

namespace App\Http\Resources;

class UserCollectionResource extends AbstractCollectionResource
{
    /**
     * @param $item
     * @return UserResource|mixed
     */
    protected function transformSingle($item)
    {
        return new UserResource($item);
    }
}
