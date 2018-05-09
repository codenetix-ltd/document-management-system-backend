<?php

namespace App\Handlers\Permissions\Document\Factory;

use App\Handlers\Permissions\Document\ADocumentActionAnyPermissionHandler;

class DocumentViewByAnyFactoryPermissionHandler extends ADocumentActionAnyPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_view_by_any_factory';
    }
}