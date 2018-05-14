<?php

namespace App\Listeners;

use App\Events\Template\TemplateCreateEvent;
use App\Events\Template\TemplateDeleteEvent;
use App\Events\Template\TemplateUpdateEvent;
use Illuminate\Events\Dispatcher;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class TemplateEventSubscriber extends AbstractLogEventSubscriber
{
    public function create(TemplateCreateEvent $event)
    {
        $this->addLog('Template was created', $event->getTemplate()->getId());
    }

    public function update(TemplateUpdateEvent $event)
    {
        $this->addLog('Template was updated', $event->getTemplate()->getId());
    }

    public function delete(TemplateDeleteEvent $event)
    {
        $this->addLog('Template was deleted', $event->getTemplate()->getId());
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen(TemplateCreateEvent::class, self::class.'@create');
        $events->listen(TemplateUpdateEvent::class, self::class.'@update');
        $events->listen(TemplateDeleteEvent::class, self::class.'@delete');
    }

    public function getReferenceType(): string
    {
        return 'template';
    }
}
