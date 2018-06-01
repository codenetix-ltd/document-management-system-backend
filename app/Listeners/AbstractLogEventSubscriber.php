<?php

namespace App\Listeners;

use App\Contracts\Helpers\ILogger;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Auth;

abstract class AbstractLogEventSubscriber
{
    /**
     * @var ILogger
     */
    private $logger;

    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    private $user;

    /**
     * @param Dispatcher $events
     * @return mixed
     */
    abstract public function subscribe(Dispatcher $events);
    /**
     * @return string
     */
    abstract public function getReferenceType():string ;

    /**
     * AbstractLogEventSubscriber constructor.
     * @param ILogger $logger
     */
    public function __construct(ILogger $logger)
    {
        $this->user = Auth::user();
        $this->logger = $logger;
    }

    /**
     * @param string  $body
     * @param integer $referenceId
     * @return void
     */
    protected function addLog(string $body, int $referenceId)
    {
        $this->logger->write($this->user->getAuthIdentifier(), $body, $referenceId, $this->getReferenceType());
    }
}
