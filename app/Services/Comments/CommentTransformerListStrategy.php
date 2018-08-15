<?php

namespace App\Services\Comments;

use Illuminate\Database\Eloquent\Collection;

class CommentTransformerListStrategy implements ITransformerStrategy
{

    /**
     * @param Collection $comments
     * @return CommentsCollection
     */
    public function make(Collection $comments)
    {
        // TODO: Implement getStructureByDocId() method.
    }
}
