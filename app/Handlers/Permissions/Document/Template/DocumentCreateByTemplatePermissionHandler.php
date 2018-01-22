<?php

namespace App\Handlers\Permissions\Document\Template;

use App\Handlers\Permissions\ABlankPermissionHandler;

class DocumentCreateByTemplatePermissionHandler extends ABlankPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_create_by_template';
    }
}