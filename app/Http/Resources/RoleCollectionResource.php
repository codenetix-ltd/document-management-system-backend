<?php

namespace App\Http\Resources;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class RoleCollectionResource extends AbstractCollectionResource
{
    protected function transformSingle($item)
    {
        return new RoleResource($item);
    }
}
