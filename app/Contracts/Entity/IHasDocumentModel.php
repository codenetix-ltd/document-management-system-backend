<?php

namespace App\Contracts\Entity;

use App\Entities\Document;

interface IHasDocumentModel
{
    public function getDocument() : Document;
    public function setDocument(Document $document) : void;
}
