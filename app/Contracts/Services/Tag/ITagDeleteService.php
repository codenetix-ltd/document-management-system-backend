<?php

namespace App\Contracts\Services\Tag;

use App\Contracts\Repositories\ITagRepository;

interface ITagDeleteService
{
    public function __construct(ITagRepository $repository);

    public function delete(int $id) : ?bool;
}