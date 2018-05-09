<?php

namespace App\Handlers\Permissions\Document;

class DocumentUpdateAnyPermissionHandler extends ADocumentActionAnyPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_update_any';
    }
}