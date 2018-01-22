<?php

namespace App\Contracts\Entity;

use App\Context\DocumentAuthorizeContext;

interface IHasDocumentAuthorizeContext
{
    public function getDocumentAuthorizeContext() : DocumentAuthorizeContext;
    public function setDocumentAuthorizeContext(DocumentAuthorizeContext $documentAuthorizeContext) : void;
}
