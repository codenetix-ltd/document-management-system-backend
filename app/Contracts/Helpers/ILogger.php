<?php

namespace App\Contracts\Helpers;

use App\Contracts\Models\IUser;

interface ILogger
{
    public function write(IUser $user, string $body, int $referenceId, string $referenceType) : void;
}