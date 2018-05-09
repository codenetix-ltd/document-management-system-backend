<?php

namespace App\Handlers\Permissions\Document;

use App\Context\DocumentAuthorizeContext;
use App\Contracts\Models\IRole;

abstract class ADocumentActionAnyPermissionHandler extends ADocumentPermissionHandler
{
    public function handle(DocumentAuthorizeContext $context): bool
    {
        $roles = $context->getUser()->roles;
        foreach ($roles as $role) {
            /** @var IRole $role */
            if ($role->hasPermission($this->getPermissionName())) return true;
        }

        return false;
    }
}