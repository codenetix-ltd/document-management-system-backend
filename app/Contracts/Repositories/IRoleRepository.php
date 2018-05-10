<?php

namespace App\Contracts\Repositories;

use App\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IRoleRepository extends IRepository
{
    public function create(Role $tag) : Role;

    public function list(): LengthAwarePaginator;

//    public function findOrFail(int $id) : Tag;
//
//    public function update(int $id, Tag $tagInput, array $updatedFields): Tag;
//
//    public function delete(int $id): ?bool;
//
//    public function findMany(array $ids): Collection;
}