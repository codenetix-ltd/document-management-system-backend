<?php

namespace App\Services\Comments;

use App\Entities\Comment as CommentModel;

class CommentTransformer
{
    public function transform(CommentModel $commentModel)
    {
        $comment = new Comment();
        $comment->setId($commentModel->id);
        $comment->setUserId($commentModel->user_id);
        $comment->setEntityId($commentModel->commentable_id);
        $comment->setEntityType($commentModel->commentable_type);
        $comment->setParentId($commentModel->parent_id);
        $comment->setMessage($commentModel->body);
        $comment->setCreatedAt($commentModel->created_at);
        $comment->setUpdatedAt($commentModel->updated_at);
        $comment->setDeletedAt($commentModel->deleted_at);

        return $comment;
    }
}

