<?php

namespace App\Listeners;

use App\Events\Template\TemplateCreateEvent;
use App\Events\Template\TemplateDeleteEvent;
use App\Events\Template\TemplateUpdateEvent;
use Illuminate\Events\Dispatcher;

class TemplateEventSubscriber extends AEventSubscriber
{
    private $referenceType = 'template';

    public function onTemplateCreate(TemplateCreateEvent $event)
    {
        $this->logger->write($event->userSubject, 'create', $event->template->id, $this->referenceType);
    }

    public function onTemplateUpdate(TemplateUpdateEvent $event)
    {
        $this->logger->write($event->userSubject, 'update', $event->template->id, $this->referenceType);
    }

    public function onTemplateDelete(TemplateDeleteEvent $event)
    {
        $this->logger->write($event->userSubject, 'delete', $event->template->id, $this->referenceType);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\Template\TemplateCreateEvent',
            'App\Listeners\TemplateEventSubscriber@onTemplateCreate'
        );

        $events->listen(
            'App\Events\Template\TemplateUpdateEvent',
            'App\Listeners\TemplateEventSubscriber@onTemplateUpdate'
        );

        $events->listen(
            'App\Events\Template\TemplateDeleteEvent',
            'App\Listeners\TemplateEventSubscriber@onTemplateDelete'
        );
    }
}