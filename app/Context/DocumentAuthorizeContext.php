<?php

namespace App\Context;

use App\Contracts\Entity\IHasDocumentModel;
use App\Document;
use App\User;

class DocumentAuthorizeContext extends AAuthorizeContext implements IHasDocumentModel
{
    private $document;

    public function __construct(User $user, Document $document = null)
    {
        parent::__construct($user);
        $this->document = $document;
    }

    public function getDocument(): Document
    {
        return $this->document;
    }

    public function setDocument(Document $document): void
    {
        $this->document = $document;
    }
}
