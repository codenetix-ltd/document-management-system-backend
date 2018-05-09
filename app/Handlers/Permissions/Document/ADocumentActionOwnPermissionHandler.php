<?php

namespace App\Handlers\Permissions\Document;

use App\Context\DocumentAuthorizeContext;

abstract class ADocumentActionOwnPermissionHandler extends ADocumentPermissionHandler
{
    public function handle(DocumentAuthorizeContext $context): bool
    {
        if ($context->getUser()->id == $context->getDocument()->owner_id) {
            return true;
        }

        return false;
    }
}