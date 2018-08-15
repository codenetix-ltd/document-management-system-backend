<?php

namespace App\Http\Resources;

class CommentCollectionResource extends AbstractCollectionResource
{

    /**
     * @param $item
     * @return CommentResource
     */
    protected function transformSingle($item)
    {
        return new CommentResource($item);
    }
}