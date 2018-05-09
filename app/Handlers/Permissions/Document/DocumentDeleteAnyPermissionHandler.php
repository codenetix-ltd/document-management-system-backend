<?php

namespace App\Handlers\Permissions\Document;

class DocumentDeleteAnyPermissionHandler extends ADocumentActionAnyPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_delete_any';
    }
}