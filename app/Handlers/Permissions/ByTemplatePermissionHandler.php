<?php

namespace App\Handlers\Permissions;

use App\Entities\Role;
use App\Entities\User;
use Illuminate\Support\Collection;

class ByTemplatePermissionHandler
{
    /**
     * @var Collection
     */
    protected $templates;

    /**
     * @var User
     */
    private $user;

    /**
     * @var Role
     */
    private $role;

    /**
     * ByTemplatePermissionHandler constructor.
     * @param User       $user
     * @param Role       $role
     * @param Collection $templates
     */
    public function __construct(User $user, Role $role, Collection $templates)
    {
        $this->user = $user;
        $this->role = $role;
        $this->templates = $templates;
    }

    /**
     * @return boolean
     */
    public function handle(): bool
    {
        $userTemplatesIds = $this->user->templates->pluck('id');
        $roleTemplatesIds = $this->role->templates->pluck('id');
        $entityTemplatesIds = $this->templates->pluck('id');

        return !$entityTemplatesIds->intersect($roleTemplatesIds->merge($userTemplatesIds)->unique())->isEmpty();
    }
}
