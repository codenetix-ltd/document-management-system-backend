<?php

namespace App\Handlers\Permissions\Document\Factory;

class DocumentArchiveByFactoryPermissionHandler extends ADocumentActionByFactoryPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_archive_by_factory';
    }
}