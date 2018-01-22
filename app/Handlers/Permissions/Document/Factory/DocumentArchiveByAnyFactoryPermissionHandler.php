<?php

namespace App\Handlers\Permissions\Document\Factory;

use App\Handlers\Permissions\Document\ADocumentActionAnyPermissionHandler;

class DocumentArchiveByAnyFactoryPermissionHandler extends ADocumentActionAnyPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_archive_by_any_factory';
    }
}