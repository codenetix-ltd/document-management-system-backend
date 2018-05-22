<?php

namespace App\Services;

use App\Repositories\PermissionGroupRepository;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class PermissionGroupService
{
    /**
     * @var PermissionGroupRepository
     */
    protected $repository;

    /**
     * PermissionGroupService constructor.
     * @param PermissionGroupRepository $repository
     */
    public function __construct(PermissionGroupRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function list()
    {
        return $this->repository->all();
    }
}