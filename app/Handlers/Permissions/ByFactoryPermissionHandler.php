<?php

namespace App\Handlers\Permissions;
use App\Role;
use App\User;
use Illuminate\Support\Collection;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class ByFactoryPermissionHandler
{
    private $user;
    private $role;
    private $factories;

    public function __construct(User $user, Role $role, Collection $factories)
    {
        $this->user = $user;
        $this->role = $role;
        $this->factories = $factories;
    }

    public function handle(): bool
    {
        $userFactoriesIds = $this->user->factories->pluck('id');
        $roleFactoriesIds = $this->role->factories->pluck('id');
        $entityFactoriesIds = $this->factories->pluck('id');

        return !$entityFactoriesIds->intersect($roleFactoriesIds->merge($userFactoriesIds)->unique())->isEmpty();
    }
}