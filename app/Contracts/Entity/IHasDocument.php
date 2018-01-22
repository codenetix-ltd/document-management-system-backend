<?php

namespace App\Contracts\Entity;

use App\Entity\Document;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
interface IHasDocument
{
    public function getDocument() : Document;
    public function setDocument(Document $document) : void;
}
