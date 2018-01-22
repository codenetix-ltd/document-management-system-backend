<?php

namespace App\Handlers\Permissions\Document\Factory;

use App\Handlers\Permissions\Document\ADocumentActionAnyPermissionHandler;

class DocumentDeleteByAnyFactoryPermissionHandler extends ADocumentActionAnyPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_delete_by_any_factory';
    }
}