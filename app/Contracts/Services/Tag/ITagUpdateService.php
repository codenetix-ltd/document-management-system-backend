<?php

namespace App\Contracts\Services\Tag;

use App\Tag;

interface ITagUpdateService
{
    public function update(int $id, Tag $tagInput, array $updatedFields) : Tag;
}