<?php

namespace App\Handlers\Permissions;

use App\Contracts\Entity\IHasId;
use App\User;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class ByIdPermissionHandler
{
    private $user;
    private $entity;
    private $entityClassName;
    private $permission;

    public function __construct(User $user, IHasId $entity, string $permission, string $entityClassName)
    {
        $this->user = $user;
        $this->entity = $entity;
        $this->entityClassName = $entityClassName;
        $this->permission = $permission;
    }

    public function handle(): bool
    {
        $roles = $this->user->roles;
        foreach ($roles as $role) {
            if ($role->hasPermission($this->permission, $this->entity->getId(), $this->entityClassName)) return true;
        }

        return false;
    }
}