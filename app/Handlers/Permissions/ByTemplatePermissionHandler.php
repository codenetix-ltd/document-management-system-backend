<?php

namespace App\Handlers\Permissions;

use App\Role;
use App\User;
use Illuminate\Support\Collection;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class ByTemplatePermissionHandler
{

    protected $templates;

    public function __construct(User $user, Role $role, Collection $templates)
    {
        $this->user = $user;
        $this->role = $role;
        $this->templates = $templates;
    }

    public function handle(): bool
    {
        $userTemplatesIds = $this->user->templates->pluck('id');
        $roleTemplatesIds = $this->role->templates->pluck('id');
        $entityTemplatesIds = $this->templates->pluck('id');

        return !$entityTemplatesIds->intersect($roleTemplatesIds->merge($userTemplatesIds)->unique())->isEmpty();
    }
}