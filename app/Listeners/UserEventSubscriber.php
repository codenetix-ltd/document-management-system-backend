<?php

namespace App\Listeners;

use App\Events\User\UserCreateEvent;
use App\Events\User\UserDeleteEvent;
use App\Events\User\UserUpdateEvent;
use Illuminate\Events\Dispatcher;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class UserEventSubscriber extends AEventSubscriber
{
    private $referenceType = 'user';

    public function onUserLogin(Login $event)
    {
        $this->logger->write($event->user, 'logged in', $event->user->id, $this->referenceType);
    }

    public function onUserLogout(Logout $event)
    {
        $this->logger->write($event->user, 'logged out', $event->user->id, $this->referenceType);
    }

    public function onUserCreate(UserCreateEvent $event)
    {
        $this->logger->write($event->userSubject, 'create', $event->user->id, $this->referenceType);
    }

    public function onUserUpdate(UserUpdateEvent $event)
    {
        $this->logger->write($event->userSubject, 'update', $event->user->id, $this->referenceType);
    }

    public function onUserDelete(UserDeleteEvent $event)
    {
        $this->logger->write($event->userSubject, 'delete', $event->user->id, $this->referenceType);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventSubscriber@onUserLogin'
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'App\Listeners\UserEventSubscriber@onUserLogout'
        );

        $events->listen(
            'App\Events\User\UserCreateEvent',
            'App\Listeners\UserEventSubscriber@onUserCreate'
        );

        $events->listen(
            'App\Events\User\UserUpdateEvent',
            'App\Listeners\UserEventSubscriber@onUserUpdate'
        );

        $events->listen(
            'App\Events\User\UserDeleteEvent',
            'App\Listeners\UserEventSubscriber@onUserDelete'
        );
    }

}