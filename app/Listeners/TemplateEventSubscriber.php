<?php

namespace App\Listeners;

use App\Events\Template\TemplateCreateEvent;
use App\Events\Template\TemplateDeleteEvent;
use App\Events\Template\TemplateUpdateEvent;
use Illuminate\Events\Dispatcher;

class TemplateEventSubscriber extends AbstractLogEventSubscriber
{
    /**
     * @param TemplateCreateEvent $event
     * @return void
     */
    public function create(TemplateCreateEvent $event)
    {
        $this->addLog('Template was created', $event->getTemplate()->id);
    }

    /**
     * @param TemplateUpdateEvent $event
     * @return void
     */
    public function update(TemplateUpdateEvent $event)
    {
        $this->addLog('Template was updated', $event->getTemplate()->id);
    }

    /**
     * @param TemplateDeleteEvent $event
     * @return void
     */
    public function delete(TemplateDeleteEvent $event)
    {
        $this->addLog('Template was deleted', $event->getTemplate()->id);
    }

    /**
     * @param Dispatcher $events
     * @return void
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(TemplateCreateEvent::class, self::class.'@create');
        $events->listen(TemplateUpdateEvent::class, self::class.'@update');
        $events->listen(TemplateDeleteEvent::class, self::class.'@delete');
    }

    /**
     * @return string
     */
    public function getReferenceType(): string
    {
        return 'template';
    }
}
