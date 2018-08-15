<?php

namespace App\Services\Comments;

use Illuminate\Support\Collection;

class CommentTransformerListStrategy implements ITransformerStrategy
{
    /**
     * @param Collection   $comments
     * @param integer      $pageNumber
     * @param integer|null $currentParentId
     * @return CommentsCollection
     */
    public function make(Collection $comments, int $pageNumber = 1, int $currentParentId = null): CommentsCollection
    {
        // TODO: Implement getStructureByDocId() method.
        $collection= new CommentsCollection([]);
        return $collection;
    }
}
