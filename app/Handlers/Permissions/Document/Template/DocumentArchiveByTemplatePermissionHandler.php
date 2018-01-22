<?php

namespace App\Handlers\Permissions\Document\Template;

class DocumentArchiveByTemplatePermissionHandler extends ADocumentActionByTemplatePermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_archive_by_template';
    }
}