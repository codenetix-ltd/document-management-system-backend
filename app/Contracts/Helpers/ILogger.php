<?php

namespace App\Contracts\Helpers;

interface ILogger
{
    public function write($userId, $body, $referenceId, $referenceType);
}