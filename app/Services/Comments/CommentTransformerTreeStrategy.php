<?php

namespace App\Services\Comments;

use Illuminate\Support\Collection;

class CommentTransformerTreeStrategy implements ITransformerStrategy
{
    /**
     * @param Collection $commentModels
     * @param int $currentParentId
     * @return CommentsCollection
     */
    public function make(Collection $commentModels, $currentParentId = null): CommentsCollection
    {
        $transformer = new CommentTransformer();
        return $this->toTree($commentModels, $transformer, $currentParentId);
    }

    /**
     * @param Collection $commentModels
     * @param CommentTransformer $transformer
     * @param null $currentParentId
     * @return CommentsCollection
     */
    public function toTree(Collection $commentModels, CommentTransformer $transformer, $currentParentId = null): CommentsCollection
    {
        $resultCollection = new CommentsCollection([]);
        foreach ($commentModels as $currentCommentModel) {
            $commentEntity = $transformer->transform($currentCommentModel);
            if ($currentCommentModel->parent_id == $currentParentId) {
                $branchCollection = $this->toTree($commentModels, $transformer, $commentEntity->getId());
                $commentEntity->setChildren($branchCollection);
                $resultCollection->push($commentEntity);
            }
        }
        return $resultCollection;
    }
}