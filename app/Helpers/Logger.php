<?php

namespace App\Helpers;

use App\Contracts\Helpers\ILogger;
use App\Contracts\Models\IUser;
use App\Log;

class Logger implements ILogger
{
    public function write(IUser $user, string $body, int $referenceId, string $referenceType) : void
    {
        $log = new Log;
        $log->user_id = $user->id;
        $log->body = $body;
        $log->reference_id = $referenceId;
        $log->reference_type = $referenceType;
        $log->save();
    }
}