<?php

namespace App\Contracts\Entity;

use App\Entities\Document;

interface IHasDocumentModel
{
    /**
     * @return Document
     */
    public function getDocument() : Document;

    /**
     * @param Document $document
     * @return void
     */
    public function setDocument(Document $document) : void;
}
