<?php

namespace App\Handlers\Permissions\Document;

class DocumentViewOwnPermissionHandler extends ADocumentActionOwnPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_view_own';
    }
}