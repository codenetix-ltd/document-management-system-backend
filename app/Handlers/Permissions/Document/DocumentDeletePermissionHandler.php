<?php

namespace App\Handlers\Permissions\Document;

class DocumentDeletePermissionHandler extends ADocumentActionPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_delete';
    }
}