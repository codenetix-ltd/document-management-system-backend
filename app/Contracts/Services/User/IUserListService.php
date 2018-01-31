<?php

namespace App\Contracts\Services\User;

use App\Contracts\Repositories\IUserRepository;
use App\Contracts\Services\Base\IListService;

interface IUserListService extends IListService
{
    public function __construct(IUserRepository $repository);
}