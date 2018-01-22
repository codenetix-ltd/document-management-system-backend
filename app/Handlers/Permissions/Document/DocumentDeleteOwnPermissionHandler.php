<?php

namespace App\Handlers\Permissions\Document;

class DocumentDeleteOwnPermissionHandler extends ADocumentActionOwnPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_delete_own';
    }
}