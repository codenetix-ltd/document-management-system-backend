<?php

namespace App\Listeners;

use App\Events\Label\LabelCreateEvent;
use App\Events\Label\LabelDeleteEvent;
use App\Events\Label\LabelUpdateEvent;
use Illuminate\Events\Dispatcher;

class LabelEventSubscriber extends AbstractLogEventSubscriber
{
    /**
     * @param LabelCreateEvent $event
     * @return void
     */
    public function create(LabelCreateEvent $event)
    {
        $this->addLog('Label was created', $event->getLabel()->id);
    }

    /**
     * @param LabelUpdateEvent $event
     * @return void
     */
    public function update(LabelUpdateEvent $event)
    {
        $this->addLog('Label was updated', $event->getLabel()->id);
    }

    /**
     * @param LabelDeleteEvent $event
     * @return void
     */
    public function delete(LabelDeleteEvent $event)
    {
        $this->addLog('Label was deleted', $event->getLabel()->id);
    }

    /**
     * @param Dispatcher $events
     * @return void
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(LabelCreateEvent::class, self::class.'@create');
        $events->listen(LabelUpdateEvent::class, self::class.'@update');
        $events->listen(LabelDeleteEvent::class, self::class.'@delete');
    }

    /**
     * @return string
     */
    public function getReferenceType(): string
    {
        return 'label';
    }
}
