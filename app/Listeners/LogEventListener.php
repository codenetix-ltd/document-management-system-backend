<?php

namespace App\Listeners;

use App\Events\Event;
use App\Events\UserEvent;
use App\Events\UserLogin;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param Event $event
     * @return void
     */
    public function handle(UserEvent $event)
    {
        echo 'event was fired';
    }
}
