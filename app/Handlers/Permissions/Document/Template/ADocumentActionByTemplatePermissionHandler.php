<?php

namespace App\Handlers\Permissions\Document\Template;

use App\Context\DocumentAuthorizeContext;
use App\Contracts\Models\IRole;
use App\Handlers\Permissions\Document\ADocumentPermissionHandler;

abstract class ADocumentActionByTemplatePermissionHandler extends ADocumentPermissionHandler
{
    public function handle(DocumentAuthorizeContext $context): bool
    {
        $roles = $context->getUser()->roles;
        foreach ($roles as $role) {
            /** @var IRole $role */
            if ($role->hasPermission($this->getPermissionName(), $context->getDocument()->template_id, 'template')) return true;
        }

        return false;
    }
}