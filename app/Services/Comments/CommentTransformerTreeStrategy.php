<?php

namespace App\Services\Comments;

use Illuminate\Support\Collection;

class CommentTransformerTreeStrategy implements ITransformerStrategy
{
    /**
     * @param Collection $commentModels
     * @param int $pageNumber
     * @param int $currentParentId
     * @return CommentsCollection
     */
    public function make(Collection $commentModels, int $pageNumber = 1, int $currentParentId = null): CommentsCollection
    {
        $transformer = new CommentTransformer();
        return $this->toTree($commentModels, $transformer, $pageNumber, $currentParentId);
    }

    /**
     * @param Collection $commentModels
     * @param ITransformer $transformer
     * @param int $pageNumber
     * @param int $currentParentId
     * @return CommentsCollection
     */
    private function toTree(Collection $commentModels, ITransformer $transformer, int $pageNumber, int $currentParentId = null): CommentsCollection
    {
        $resultCollection = new CommentsCollection([], $pageNumber);
        foreach ($commentModels as $currentCommentModel) {
            $commentEntity = $transformer->transform($currentCommentModel);
            if ($currentCommentModel->parent_id == $currentParentId) {
                $branchCollection = $this->toTree($commentModels, $transformer, $pageNumber, $commentEntity->getId());
                $commentEntity->setChildren($branchCollection);
                $resultCollection->push($commentEntity);
            }
        }
        return $resultCollection;
    }
}