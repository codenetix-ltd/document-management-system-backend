<?php

namespace App\Contracts\Services\Tag;

use App\Tag;

interface ITagCreateService
{
    public function create(Tag $tag) : Tag;
}