<?php

namespace App\Contracts\Repositories;

use App\Role;

interface IRoleRepository extends IRepository
{
    public function create(Role $tag) : Role;

//    public function findOrFail(int $id) : Tag;
//
//    public function update(int $id, Tag $tagInput, array $updatedFields): Tag;
//
//    public function delete(int $id): ?bool;
//
//    public function findMany(array $ids): Collection;
}