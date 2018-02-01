<?php

namespace App\Contracts\Services\Type;

use App\Contracts\Repositories\ITypeRepository;
use App\Contracts\Services\Base\IListService;

interface ITypeListService extends IListService
{
    public function __construct(ITypeRepository $repository);
}