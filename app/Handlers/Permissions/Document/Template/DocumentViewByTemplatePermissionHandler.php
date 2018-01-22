<?php

namespace App\Handlers\Permissions\Document\Template;

class DocumentViewByTemplatePermissionHandler extends ADocumentActionByTemplatePermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_view_by_template';
    }
}