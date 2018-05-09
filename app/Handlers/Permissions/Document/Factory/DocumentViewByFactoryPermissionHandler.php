<?php

namespace App\Handlers\Permissions\Document\Factory;

class DocumentViewByFactoryPermissionHandler extends ADocumentActionByFactoryPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_view_by_factory';
    }
}