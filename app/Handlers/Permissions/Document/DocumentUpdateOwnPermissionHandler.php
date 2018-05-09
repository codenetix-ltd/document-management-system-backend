<?php

namespace App\Handlers\Permissions\Document;

class DocumentUpdateOwnPermissionHandler extends ADocumentActionOwnPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_update_own';
    }
}