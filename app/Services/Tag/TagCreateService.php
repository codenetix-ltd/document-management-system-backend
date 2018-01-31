<?php

namespace App\Services\Tag;

use App\Contracts\Models\ITag;
use App\Contracts\Repositories\ITagRepository;
use App\Contracts\Services\Tag\ITagCreateService;

class TagCreateService implements ITagCreateService
{
    private $repository;

    public function __construct(ITagRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(ITag $tag) : ITag
    {
        $tag = $this->repository->create($tag);

        return $tag;
    }
}