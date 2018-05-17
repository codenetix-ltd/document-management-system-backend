<?php

namespace App\Services;

use App\Entities\PermissionGroup;
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
    public function list(){
        return $this->repository->all();
    }

    /**
     * @param int $id
     * @return PermissionGroup
     */
    public function find(int $id){
        return $this->repository->find($id);
    }

    /**
     * @param array $data
     * @return PermissionGroup
     */
    public function create(array $data){
        return $this->repository->create($data);
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id){
        return $this->repository->update($data, $id);
    }

    /**
     * @param int $id
     */
    public function delete(int $id){
        $this->repository->delete($id);
    }
}