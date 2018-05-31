<?php

namespace App\Listeners;

use App\Contracts\Helpers\ILogger;
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

    public function __construct(ILogger $logger)
    {
        $this->user = Auth::user();
        $this->logger = $logger;
    }

    protected function addLog($body, $referenceId)
    {
        $this->logger->write($this->user->getAuthIdentifier(), $body, $referenceId, $this->getReferenceType());
    }

    abstract public function subscribe(Dispatcher $events);
    abstract public function getReferenceType():string ;
}
