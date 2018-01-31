<?php

namespace App\Contracts\Services\Tag;

use App\Contracts\Models\ITag;
use App\Contracts\Repositories\ITagRepository;

interface ITagUpdateService
{
    public function __construct(ITagRepository $repository);

    public function update(int $id, ITag $tagInput, array $updatedFields) : ITag;
}