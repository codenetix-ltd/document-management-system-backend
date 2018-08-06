<?php

namespace App\Services\Comments;

use Illuminate\Support\Collection as BaseCollection;
use Traversable;

class CommentsCollection extends BaseCollection
{
    public $pageNumber;

    public function __construct(array $items, int $pageNumber = 1)
    {
        parent::__construct($items);
        $this->pageNumber = $pageNumber;
    }

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new DatabaseCommentIterator($this, $this->pageNumber);
    }
}