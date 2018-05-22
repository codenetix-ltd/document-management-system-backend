<?php

namespace App\Contracts\Helpers;

use App\Entities\User;

interface ILogger
{
    public function write(User $user, string $body, int $referenceId, string $referenceType) : void;
}