<?php

namespace App\Services\Comments;

use Illuminate\Database\Eloquent\Collection;

interface ITransformerStrategy
{
    public function make(Collection $comments, int $pageNumber);
}