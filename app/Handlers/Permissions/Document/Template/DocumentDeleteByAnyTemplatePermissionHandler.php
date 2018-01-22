<?php

namespace App\Handlers\Permissions\Document\Template;

use App\Handlers\Permissions\Document\ADocumentActionAnyPermissionHandler;

class DocumentDeleteByAnyTemplatePermissionHandler extends ADocumentActionAnyPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_delete_by_any_template';
    }
}