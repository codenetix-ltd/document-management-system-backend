<?php

namespace App\Listeners;

use App\Events\User\UserCreateEvent;
use App\Events\User\UserDeleteEvent;
use App\Events\User\UserUpdateEvent;
use Illuminate\Events\Dispatcher;

class UserEventSubscriber extends AbstractLogEventSubscriber
{
    /**
     * @param UserCreateEvent $event
     * @return void
     */
    public function create(UserCreateEvent $event)
    {
        $this->addLog('User was created', $event->getUser()->id);
    }

    /**
     * @param UserUpdateEvent $event
     * @return void
     */
    public function update(UserUpdateEvent $event)
    {
        $this->addLog('User was updated', $event->getUser()->id);
    }

    /**
     * @param UserDeleteEvent $event
     * @return void
     */
    public function delete(UserDeleteEvent $event)
    {
        $this->addLog('User was deleted', $event->getUser()->id);
    }

    /**
     * @param Dispatcher $events
     * @return void
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(UserCreateEvent::class, self::class.'@create');
        $events->listen(UserUpdateEvent::class, self::class.'@update');
        $events->listen(UserDeleteEvent::class, self::class.'@delete');
    }

    /**
     * @return string
     */
    public function getReferenceType(): string
    {
        return 'user';
    }
}
