<?php

namespace App\Listeners;

use App\Events\User\UserCreateEvent;
use App\Events\User\UserDeleteEvent;
use App\Events\User\UserUpdateEvent;
use Illuminate\Events\Dispatcher;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class UserEventSubscriber extends AbstractLogEventSubscriber
{
    public function create(UserCreateEvent $event)
    {
        $this->addLog('User was created', $event->getUser()->id);
    }

    public function update(UserUpdateEvent $event)
    {
        $this->addLog('User was updated', $event->getUser()->id);
    }

    public function delete(UserDeleteEvent $event)
    {
        $this->addLog('User was deleted', $event->getUser()->id);
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen(UserCreateEvent::class, self::class.'@create');
        $events->listen(UserUpdateEvent::class, self::class.'@update');
        $events->listen(UserDeleteEvent::class, self::class.'@delete');
    }

    public function getReferenceType(): string
    {
        return 'user';
    }
}
