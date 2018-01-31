<?php

namespace App\Services\Tag;

use App\Contracts\Models\ITag;
use App\Contracts\Repositories\ITagRepository;
use App\Contracts\Services\Tag\ITagGetService;

class TagGetService implements ITagGetService
{
    private $repository;

    public function __construct(ITagRepository $repository)
    {
        $this->repository = $repository;
    }

    public function get(int $id): ITag
    {
        return $this->repository->findOrFail($id);
    }
}