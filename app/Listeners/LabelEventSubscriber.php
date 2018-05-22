<?php

namespace App\Listeners;

use App\Events\Label\LabelCreateEvent;
use App\Events\Label\LabelDeleteEvent;
use App\Events\Label\LabelUpdateEvent;
use Illuminate\Events\Dispatcher;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class LabelEventSubscriber extends AbstractLogEventSubscriber
{
    public function create(LabelCreateEvent $event)
    {
        $this->addLog('Label was created', $event->getLabel()->id);
    }

    public function update(LabelUpdateEvent $event)
    {
        $this->addLog('Label was updated', $event->getLabel()->id);
    }

    public function delete(LabelDeleteEvent $event)
    {
        $this->addLog('Label was deleted', $event->getLabel()->id);
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen(LabelCreateEvent::class, self::class.'@create');
        $events->listen(LabelUpdateEvent::class, self::class.'@update');
        $events->listen(LabelDeleteEvent::class, self::class.'@delete');
    }

    public function getReferenceType(): string
    {
        return 'label';
    }
}
