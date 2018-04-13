<?php

namespace App\Contracts\Services\Tag;

use App\Tag;

interface ITagGetService
{
    public function get(int $id) : Tag;
}