<?php

namespace App\Handlers\Permissions\Document\Template;

use App\Handlers\Permissions\Document\ADocumentActionAnyPermissionHandler;

class DocumentArchiveByAnyTemplatePermissionHandler extends ADocumentActionAnyPermissionHandler
{
    public function getPermissionName(): string
    {
        return 'document_archive_by_any_template';
    }
}