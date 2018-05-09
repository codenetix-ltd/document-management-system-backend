<?php

namespace App\Handlers\Permissions\Document;

use App\Handlers\Permissions\ABlankPermissionHandler;

class DocumentCreatePermissionHandler extends ABlankPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_create';
    }
}