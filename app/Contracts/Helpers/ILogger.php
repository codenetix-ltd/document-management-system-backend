<?php

namespace App\Contracts\Helpers;

interface ILogger
{
    /**
     * @param integer $userId
     * @param string  $body
     * @param integer $referenceId
     * @param string  $referenceType
     * @return mixed
     */
    public function write(int $userId, string $body, int $referenceId, string $referenceType);
}
