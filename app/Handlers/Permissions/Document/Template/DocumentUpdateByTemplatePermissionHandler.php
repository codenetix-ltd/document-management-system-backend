<?php

namespace App\Handlers\Permissions\Document\Template;

class DocumentUpdateByTemplatePermissionHandler extends ADocumentActionByTemplatePermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_update_by_template';
    }
}