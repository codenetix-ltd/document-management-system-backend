<?php

namespace App\Repositories;

use App\Contracts\Repositories\IRoleRepository;
use App\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RoleRepository implements IRoleRepository
{
    public function create(Role $role): Role
    {
        $role->save();
        $role = Role::findOrFail($role->getId());

        return $role;
    }

//    public function findOrFail(int $id): Tag
//    {
//        return Tag::findOrFail($id);
//    }
//
//    public function update(int $id, Tag $tagInput, array $updatedFields): Tag
//    {
//        $tag = Tag::findOrFail($id);
//
//        foreach ($updatedFields as $fieldKey) {
//            $tag->{dms_build_setter($fieldKey)}($tagInput->{dms_build_getter($fieldKey)}());
//        }
//
//        $tag->save();
//
//        return $tag;
//    }
//
//    public function delete(int $id): ?bool
//    {
//        return Tag::where('id', $id)->delete();
//    }
//
    public function list(): LengthAwarePaginator
    {
        return Role::paginate();
    }
//
//    public function findMany(array $ids): Collection
//    {
//        return Tag::findMany($ids);
//    }
}