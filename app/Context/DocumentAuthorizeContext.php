<?php

namespace App\Context;

use App\Contracts\Entity\IHasDocumentModel;
use App\Entities\Document;
use App\Entities\User;
use Illuminate\Contracts\Auth\Authenticatable;

class DocumentAuthorizeContext extends AAuthorizeContext implements IHasDocumentModel
{
    /**
     * @var Document
     */
    private $document;

    /**
     * DocumentAuthorizeContext constructor.
     * @param Authenticatable          $user
     * @param Document|null $document
     */
    public function __construct(Authenticatable $user, Document $document = null)
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
