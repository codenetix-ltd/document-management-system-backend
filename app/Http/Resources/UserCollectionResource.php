<?php

namespace App\Http\Resources;

class UserCollectionResource extends AbstractCollectionResource
{
    protected function transformSingle($item)
    {
        return new UserResource($item);
    }
}
