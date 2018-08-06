<?php

namespace App\Http\Resources;

class CommentCollectionResource extends AbstractCollectionResource
{

    /**
     * @param $item
     * @return CommentResource|mixed
     */
    protected function transformSingle($item)
    {
        return new CommentResource($item);
    }
}