<?php

namespace App\Services\Comments;


class LazyRootComment extends AComment implements IRootComment
{
    protected $children = [];
    protected $rootComment;

    public function __construct(IRootComment $rootComment)
    {
        $this->rootComment = $rootComment;
    }

    public function add(AComment $comment): void
    {
        $this->children[] = $comment;
    }

    /**
     * Get comment from tree
     */
    public function get()
    {
        // TODO: get() method.
    }
}