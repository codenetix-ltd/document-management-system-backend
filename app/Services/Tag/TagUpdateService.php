<?php

namespace App\Services\Tag;

use App\Contracts\Models\ITag;
use App\Contracts\Repositories\ITagRepository;
use App\Contracts\Services\Tag\ITagUpdateService;

class TagUpdateService implements ITagUpdateService
{
    private $repository;

    public function __construct(ITagRepository $repository)
    {
        $this->repository = $repository;
    }

    public function update(int $id, ITag $tagInput, array $updatedFields): ITag
    {
        $tag = $this->repository->update($id, $tagInput, $updatedFields);

        return $tag;
    }
}