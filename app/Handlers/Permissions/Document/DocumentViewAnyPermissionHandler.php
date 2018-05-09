<?php

namespace App\Handlers\Permissions\Document;

class DocumentViewAnyPermissionHandler extends ADocumentActionAnyPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_view_any';
    }
}