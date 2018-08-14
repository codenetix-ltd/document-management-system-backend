<?php

namespace App\Services\Comments;

use Illuminate\Support\Collection;

interface ITransformerStrategy
{
    public function make(Collection $comments, int $pageNumber = 1, int $currentParentId = null): CommentsCollection;
}