<?php

namespace App\Listeners;

use App\Events\Label\LabelCreateEvent;
use App\Events\Label\LabelDeleteEvent;
use App\Events\Label\LabelUpdateEvent;
use Illuminate\Events\Dispatcher;

class LabelEventSubscriber extends AEventSubscriber
{
    private $referenceType = 'label';

    public function onLabelCreate(LabelCreateEvent $event)
    {
        $this->logger->write($event->userSubject, 'create', $event->label->id, $this->referenceType);
    }

    public function onLabelUpdate(LabelUpdateEvent $event)
    {
        $this->logger->write($event->userSubject, 'update', $event->label->id, $this->referenceType);
    }

    public function onLabelDelete(LabelDeleteEvent $event)
    {
        $this->logger->write($event->userSubject, 'delete', $event->label->id, $this->referenceType);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\Label\LabelCreateEvent',
            'App\Listeners\LabelEventSubscriber@onLabelCreate'
        );

        $events->listen(
            'App\Events\Label\LabelUpdateEvent',
            'App\Listeners\LabelEventSubscriber@onLabelUpdate'
        );

        $events->listen(
            'App\Events\Label\LabelDeleteEvent',
            'App\Listeners\LabelEventSubscriber@onLabelDelete'
        );
    }
}