<?php

namespace App\Services\Comments;

use Illuminate\Support\Collection;

interface ITransformerStrategy
{
    public function make(Collection $comments, $currentParentId = null): CommentsCollection;
}