<?php

namespace App\Services\Components;

use App\Events\Event;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
interface IEventDispatcher
{
    public function dispatch(Event $event);
}
