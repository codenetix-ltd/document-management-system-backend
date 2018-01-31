<?php

namespace App\Contracts\Services\Tag;

use App\Contracts\Models\ITag;
use App\Contracts\Repositories\ITagRepository;

interface ITagCreateService
{
    public function __construct(ITagRepository $repository);

    public function create(ITag $tag) : ITag;
}