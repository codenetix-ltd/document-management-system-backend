<?php

namespace App\Contracts\Services\Tag;

use App\Contracts\Models\ITag;
use App\Contracts\Repositories\ITagRepository;

interface ITagGetService
{
    public function __construct(ITagRepository $repository);

    public function get(int $id) : ITag;
}