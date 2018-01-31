<?php

namespace App\Contracts\Services\Tag;

use App\Contracts\Repositories\ITagRepository;
use App\Contracts\Services\Base\IListService;

interface ITagListService extends IListService
{
    public function __construct(ITagRepository $repository);
}