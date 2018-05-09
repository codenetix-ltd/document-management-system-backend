<?php

namespace App\Handlers\Permissions\Document;

class DocumentUpdatePermissionHandler extends ADocumentActionPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_update';
    }
}