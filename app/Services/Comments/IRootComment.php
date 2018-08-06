<?php

namespace App\Services\Comments;


interface IRootComment
{
    public function add(AComment $comment): void;
}