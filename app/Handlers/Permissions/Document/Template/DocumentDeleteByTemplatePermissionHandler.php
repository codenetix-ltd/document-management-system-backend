<?php

namespace App\Handlers\Permissions\Document\Template;

class DocumentDeleteByTemplatePermissionHandler extends ADocumentActionByTemplatePermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_delete_by_template';
    }
}