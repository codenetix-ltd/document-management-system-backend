<?php

namespace App\Services;

use App\Contracts\Repositories\IRoleRepository;
use App\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;

class RoleService
{
    private $repository;

    public function __construct(IRoleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(Role $role) : Role
    {
        $role = $this->repository->create($role);

        return $role;
    }

//    public function delete(int $id): ?bool
//    {
//        return $this->repository->delete($id);
//    }
//
//    public function get(int $id): Tag
//    {
//        return $this->repository->findOrFail($id);
//    }
//
//    public function list(): LengthAwarePaginatorContract
//    {
//        return $this->repository->list();
//    }
//
//    public function update(int $id, Tag $tagInput, array $updatedFields): Tag
//    {
//        $tag = $this->repository->update($id, $tagInput, $updatedFields);
//
//        return $tag;
//    }
}
