<?php

namespace App\Handlers\Permissions\Document\Factory;

use App\Context\DocumentAuthorizeContext;
use App\Contracts\Models\IRole;
use App\Handlers\Permissions\Document\ADocumentPermissionHandler;

abstract class ADocumentActionByFactoryPermissionHandler extends ADocumentPermissionHandler
{
    public function handle(DocumentAuthorizeContext $context): bool
    {
        $roles = $context->getUser()->roles;
        foreach ($roles as $role) {
            /** @var IRole $role */
            $factoryIds = $context->getDocument()->factories->pluck('id');
            foreach ($factoryIds as $factoryId) {
                if ($role->hasPermission($this->getPermissionName(), $factoryId, 'factory')) return true;
            }
        }

        return false;
    }
}