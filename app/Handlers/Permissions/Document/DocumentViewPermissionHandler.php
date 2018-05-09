<?php

namespace App\Handlers\Permissions\Document;

class DocumentViewPermissionHandler extends ADocumentActionPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_view';
    }
}