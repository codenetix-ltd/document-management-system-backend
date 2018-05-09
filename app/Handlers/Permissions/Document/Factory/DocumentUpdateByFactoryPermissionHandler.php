<?php

namespace App\Handlers\Permissions\Document\Factory;

class DocumentUpdateByFactoryPermissionHandler extends ADocumentActionByFactoryPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_update_by_factory';
    }
}