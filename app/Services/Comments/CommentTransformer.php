<?php

namespace App\Services\Comments;

use App\Entities\Comment as CommentModel;

class CommentTransformer implements ITransformer
{

    /**
     * @param CommentModel $commentModel
     * @return Comment
     */
    public function transform(CommentModel $commentModel): Comment
    {
        $comment = new Comment();
        $comment->setId($commentModel->id);
        $comment->setUserId($commentModel->user_id);
        $comment->setEntityId($commentModel->commentable_id);
        $comment->setEntityType($commentModel->commentable_type);
        $comment->setParentId($commentModel->parent_id);
        $comment->setMessage($commentModel->body);
        $comment->setCreatedAt($commentModel->created_at->timestamp);
        $comment->setUpdatedAt($commentModel->updated_at->timestamp);
        $comment->setDeletedAt(data_get($commentModel, 'deleted_at.timestamp', null));
        return $comment;
    }
}
