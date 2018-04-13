<?php

namespace App\Services\Tag;

use App\Contracts\Repositories\ITagRepository;
use App\Contracts\Services\Tag\ITagCreateService;
use App\Tag;

class TagCreateService implements ITagCreateService
{
    private $repository;

    public function __construct(ITagRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(Tag $tag) : Tag
    {
        $tag = $this->repository->create($tag);

        return $tag;
    }
}