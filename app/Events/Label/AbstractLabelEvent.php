<?php

namespace App\Events\Label;

use App\Events\Event;
use App\Tag;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
abstract class AbstractLabelEvent extends Event
{
    /**
     * @var Tag
     */
    private $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function getTag(): Tag
    {
        return $this->tag;
    }
}
