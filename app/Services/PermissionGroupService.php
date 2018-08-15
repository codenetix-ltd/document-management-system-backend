<?php

namespace App\Services;

use App\Repositories\PermissionGroupRepository;

class PermissionGroupService
{
    use CRUDServiceTrait;

    /**
     * PermissionGroupService constructor.
     * @param PermissionGroupRepository $repository
     */
    public function __construct(PermissionGroupRepository $repository)
    {
        $this->setRepository($repository);
    }
}
