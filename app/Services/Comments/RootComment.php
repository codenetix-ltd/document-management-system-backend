<?php

namespace App\Services\Comments;



class RootComment extends AComment implements IRootComment
{
    /**
     * @var AComment[]
     */
    protected $children;

    public function __construct($pageNumber = 1)
    {
        $this->children = new CommentsCollection([], $pageNumber);
    }

    /**
     * Add comment to tree
     * @param AComment $comment
     * @return void
     */
    public function add(AComment $comment): void
    {
        $this->children[] = $comment;
    }

    /**
     * Add comment to tree
     * @param AComment $comment
     * @return void
     */
    public function remove(AComment $comment): void
    {
        foreach (array_keys($this->children, $comment) as $key)
        {
            unset($this->children[$key]);
        }
    }

    /**
     * Get comment from tree
     */
    public function get()
    {
        // TODO: get() method.
    }
}