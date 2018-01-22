<?php

namespace App\Listeners;

use App\Contracts\Helpers\ILogger;

class AEventSubscriber
{
    protected $logger;

    public function __construct(ILogger $logger)
    {
        $this->logger = $logger;
    }
}
