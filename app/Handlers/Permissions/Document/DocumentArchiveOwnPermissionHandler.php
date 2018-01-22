<?php

namespace App\Handlers\Permissions\Document;

class DocumentArchiveOwnPermissionHandler extends ADocumentActionOwnPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_archive_own';
    }
}