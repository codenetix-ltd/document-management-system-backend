<?php

namespace App\Listeners;

use App\Events\Document\DocumentCreateEvent;
use App\Events\Document\DocumentDeleteEvent;
use App\Events\Document\DocumentReadEvent;
use App\Events\Document\DocumentUpdateEvent;
use Illuminate\Events\Dispatcher;

class DocumentEventSubscriber extends AbstractLogEventSubscriber
{
    /**
     * @param DocumentCreateEvent $event
     * @return void
     */
    public function create(DocumentCreateEvent $event)
    {
        $this->addLog('Document was created', $event->getDocument()->id);
    }

    /**
     * @param DocumentReadEvent $event
     * @return void
     */
    public function read(DocumentReadEvent $event)
    {
        $this->addLog('Document was read', $event->getDocument()->id);
    }

    /**
     * @param DocumentUpdateEvent $event
     * @return void
     */
    public function update(DocumentUpdateEvent $event)
    {
        $this->addLog('Document was updated', $event->getDocument()->id);
    }

    /**
     * @param DocumentDeleteEvent $event
     * @return void
     */
    public function delete(DocumentDeleteEvent $event)
    {
        $this->addLog('Document was deleted', $event->getDocument()->id);
    }

    /**
     * @param Dispatcher $events
     * @return void
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(DocumentReadEvent::class, self::class.'@read');
        $events->listen(DocumentCreateEvent::class, self::class.'@create');
        $events->listen(DocumentUpdateEvent::class, self::class.'@update');
        $events->listen(DocumentDeleteEvent::class, self::class.'@delete');
    }

    /**
     * @return string
     */
    public function getReferenceType(): string
    {
        return 'document';
    }
}
