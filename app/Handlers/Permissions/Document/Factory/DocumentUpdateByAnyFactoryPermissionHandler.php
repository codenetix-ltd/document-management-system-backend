<?php

namespace App\Handlers\Permissions\Document\Factory;

use App\Handlers\Permissions\Document\ADocumentActionAnyPermissionHandler;

class DocumentUpdateByAnyFactoryPermissionHandler extends ADocumentActionAnyPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_update_by_any_factory';
    }
}