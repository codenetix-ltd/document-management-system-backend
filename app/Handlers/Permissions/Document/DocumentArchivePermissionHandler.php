<?php

namespace App\Handlers\Permissions\Document;

class DocumentArchivePermissionHandler extends ADocumentActionPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_archive';
    }
}