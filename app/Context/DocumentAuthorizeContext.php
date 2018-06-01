<?php

namespace App\Context;

use App\Contracts\Entity\IHasDocumentModel;
use App\Entities\Document;
use App\Entities\User;

class DocumentAuthorizeContext extends AAuthorizeContext implements IHasDocumentModel
{
    /**
     * @var Document
     */
    private $document;

    /**
     * DocumentAuthorizeContext constructor.
     * @param User          $user
     * @param Document|null $document
     */
    public function __construct(User $user, Document $document = null)
    {
        parent::__construct($user);
        $this->document = $document;
    }

    /**
     * @return Document
     */
    public function getDocument(): Document
    {
        return $this->document;
    }

    /**
     * @param Document $document
     * @return void
     */
    public function setDocument(Document $document): void
    {
        $this->document = $document;
    }
}
