<?php

namespace App\Handlers\Permissions\Document;

class DocumentArchiveAnyPermissionHandler extends ADocumentActionAnyPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_archive_any';
    }
}