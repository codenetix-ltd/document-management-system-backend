<?php

namespace App\Services\Comments;

class LeafComment extends AComment
{
    /**
     * Get comment from tree
     * @return LeafComment
     */
    public function get()
    {
        return $this;
    }
}