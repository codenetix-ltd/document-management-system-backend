<?php

namespace App\Handlers\Permissions;

use App\Contracts\Entity\IHasId;
use App\Entities\User;

class ByIdPermissionHandler
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var IHasId
     */
    private $entity;

    /**
     * @var string
     */
    private $entityClassName;

    /**
     * @var string
     */
    private $permission;

    /**
     * ByIdPermissionHandler constructor.
     * @param User   $user
     * @param IHasId $entity
     * @param string $permission
     * @param string $entityClassName
     */
    public function __construct(User $user, IHasId $entity, string $permission, string $entityClassName)
    {
        $this->user = $user;
        $this->entity = $entity;
        $this->entityClassName = $entityClassName;
        $this->permission = $permission;
    }

    /**
     * @return boolean
     */
    public function handle(): bool
    {
        $roles = $this->user->roles;
        foreach ($roles as $role) {
            if ($role->hasPermission($this->permission, $this->entity->getId(), $this->entityClassName)) {
                return true;
            }
        }

        return false;
    }
}
