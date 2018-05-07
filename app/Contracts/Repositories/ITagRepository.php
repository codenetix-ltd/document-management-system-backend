<?php

namespace App\Contracts\Repositories;

use App\Tag;
use Illuminate\Support\Collection;

interface ITagRepository extends IRepository
{
    public function create(Tag $tag) : Tag;

    public function findOrFail(int $id) : Tag;

    public function update(int $id, Tag $tagInput, array $updatedFields): Tag;

    public function delete(int $id): ?bool;

    public function findMany(array $ids): Collection;
}