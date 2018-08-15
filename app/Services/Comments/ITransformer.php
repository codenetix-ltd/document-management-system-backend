<?php

namespace App\Services\Comments;

use App\Entities\Comment as CommentModel;

interface ITransformer
{
    public function transform(CommentModel $commentModel): Comment;
}
