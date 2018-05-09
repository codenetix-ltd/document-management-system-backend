<?php

namespace App\Handlers\Permissions\Document\Factory;

use App\Handlers\Permissions\ABlankPermissionHandler;

class DocumentCreateByFactoryPermissionHandler extends ABlankPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_create_by_factory';
    }
}