<?php

namespace App\Handlers\Permissions;

use App\Context\BlankAuthorizeContext;

class GenericPermissionHandler extends ABlankPermissionHandler
{
    /**
     * @var string
     */
    private $permission;

    /**
     * GenericPermissionHandler constructor.
     * @param string $permission
     */
    public function __construct(string $permission)
    {
        $this->permission = $permission;
    }

    /**
     * @return string
     */
    public function getPermissionName(): string
    {
        return $this->permission;
    }

    /**
     * @param BlankAuthorizeContext $context
     * @return boolean
     */
    public function handle(BlankAuthorizeContext $context): bool
    {
        $roles = $context->getUser()->roles;
        foreach ($roles as $role) {
            if ($role->hasPermission($this->getPermissionName())) {
                return true;
            }
        }

        return false;
    }
}
