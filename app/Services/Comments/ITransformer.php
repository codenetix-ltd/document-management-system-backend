<?php

namespace App\Services\Comments;

use App\Entities\Comment as CommentModel;

interface ITransformer
{
    /**
     * @param CommentModel $commentModel
     * @return Comment
     */
    public function transform(CommentModel $commentModel): Comment;
}
