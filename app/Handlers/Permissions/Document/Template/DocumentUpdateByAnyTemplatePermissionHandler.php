<?php

namespace App\Handlers\Permissions\Document\Template;

use App\Handlers\Permissions\Document\ADocumentActionAnyPermissionHandler;

class DocumentUpdateByAnyTemplatePermissionHandler extends ADocumentActionAnyPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_update_by_any_template';
    }
}