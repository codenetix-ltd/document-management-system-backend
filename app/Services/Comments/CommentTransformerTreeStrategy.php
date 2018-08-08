<?php

namespace App\Services\Comments;

use Illuminate\Support\Collection;

class CommentTransformerTreeStrategy implements ITransformerStrategy
{
    public function make(Collection $commentModels): CommentsCollection
    {

        return $this->toTree($commentModels);
    }

    protected function toTree(Collection $commentModels, $currentParentId = null): CommentsCollection
    {
        $resultCollection = new CommentsCollection([]);
        foreach ($commentModels as $currentCommentModel) {
            $commentEntity = new Comment();
            $commentEntity->setAllProperty($currentCommentModel);
            if ($currentCommentModel->parent_id == $currentParentId) {
                $branchCollection = $this->toTree($commentModels, $commentEntity->getId());
                $commentEntity->setChildren($branchCollection);
                $resultCollection->push($commentEntity);
            }
        }
        return $resultCollection;
    }
}