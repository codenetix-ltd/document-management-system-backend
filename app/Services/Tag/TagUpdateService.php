<?php

namespace App\Services\Tag;

use App\Contracts\Repositories\ITagRepository;
use App\Contracts\Services\Tag\ITagUpdateService;
use App\Tag;

class TagUpdateService implements ITagUpdateService
{
    private $repository;

    public function __construct(ITagRepository $repository)
    {
        $this->repository = $repository;
    }

    public function update(int $id, Tag $tagInput, array $updatedFields): Tag
    {
        $tag = $this->repository->update($id, $tagInput, $updatedFields);

        return $tag;
    }
}