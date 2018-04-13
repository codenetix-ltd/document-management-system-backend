<?php

namespace App\Contracts\Services\User;

interface IUserDeleteService
{
    public function delete(int $id) : ?bool;
}