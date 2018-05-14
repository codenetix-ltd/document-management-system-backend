<?php

namespace App\Services\Components;

use App\Events\Event;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class LaravelEventDispatcher implements IEventDispatcher
{

    public function dispatch(Event $event)
    {
        event($event);
    }
}
