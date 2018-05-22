<?php

namespace App\Events\Document;

use App\Entities\Document;
use App\Events\Event;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
abstract class AbstractDocumentEvent extends Event
{
    /**
     * @var Document
     */
    private $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function getDocument(): Document
    {
        return $this->document;
    }
}
