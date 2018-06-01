<?php

namespace App\Events\Document;

use App\Entities\Document;
use App\Events\Event;

abstract class AbstractDocumentEvent extends Event
{
    /**
     * @var Document
     */
    private $document;

    /**
     * AbstractDocumentEvent constructor.
     * @param Document $document
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    /**
     * @return Document
     */
    public function getDocument(): Document
    {
        return $this->document;
    }
}
