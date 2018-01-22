<?php

namespace App\Contracts\Entity;

use App\Document;

interface IHasDocumentModel
{
    public function getDocument() : Document;
    public function setDocument(Document $document) : void;
}
