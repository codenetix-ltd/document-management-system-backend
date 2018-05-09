<?php

namespace App\Handlers\Permissions\Document\Template;

use App\Handlers\Permissions\Document\ADocumentActionAnyPermissionHandler;

class DocumentViewByAnyTemplatePermissionHandler extends ADocumentActionAnyPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_view_by_any_template';
    }
}