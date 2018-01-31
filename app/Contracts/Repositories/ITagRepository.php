<?php

namespace App\Contracts\Repositories;

use App\Contracts\Models\ITag;

interface ITagRepository extends IRepository
{
    public function create(ITag $tag) : ITag;

    public function findOrFail(int $id) : ITag;

    public function update(int $id, ITag $tagInput, array $updatedFields): ITag;

    public function delete(int $id): ?bool;
}