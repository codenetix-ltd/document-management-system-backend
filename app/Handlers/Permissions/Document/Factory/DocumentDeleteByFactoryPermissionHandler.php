<?php

namespace App\Handlers\Permissions\Document\Factory;

class DocumentDeleteByFactoryPermissionHandler extends ADocumentActionByFactoryPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_delete_by_factory';
    }
}