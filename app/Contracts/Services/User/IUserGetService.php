<?php

namespace App\Contracts\Services\User;

use App\User;

interface IUserGetService
{
    public function get(int $id) : User;
}