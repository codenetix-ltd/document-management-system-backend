<?php

namespace App\Listeners;

use App\Contracts\Helpers\ILogger;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Auth;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
abstract class AbstractLogEventSubscriber
{
    /**
     * @var ILogger
     */
    private $logger;
    private $user;

    public function __construct(ILogger $logger, Guard $auth)
    {
        $this->user = $auth->user();
        $this->logger = $logger;
    }

    protected function addLog($body, $referenceId)
    {
        $this->logger->write($this->user, $body, $referenceId, $this->getReferenceType());
    }

    abstract public function subscribe(Dispatcher $events);
    abstract public function getReferenceType():string ;
}
