<?php

namespace App\Listeners;

use App\Events\Document\DocumentCreateEvent;
use App\Events\Document\DocumentDeleteEvent;
use App\Events\Document\DocumentReadEvent;
use App\Events\Document\DocumentUpdateEvent;
use Illuminate\Events\Dispatcher;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class DocumentEventSubscriber extends AbstractLogEventSubscriber
{
    public function create(DocumentCreateEvent $event)
    {
        $this->addLog('Document was created', $event->getDocument()->id);
    }

    public function read(DocumentReadEvent $event)
    {
        $this->addLog('Document was read', $event->getDocument()->id);
    }

    public function update(DocumentUpdateEvent $event)
    {
        $this->addLog('Document was updated', $event->getDocument()->id);
    }

    public function delete(DocumentDeleteEvent $event)
    {
        $this->addLog('Document was deleted', $event->getDocument()->id);
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen(DocumentReadEvent::class, self::class.'@read');
        $events->listen(DocumentCreateEvent::class, self::class.'@create');
        $events->listen(DocumentUpdateEvent::class, self::class.'@update');
        $events->listen(DocumentDeleteEvent::class, self::class.'@delete');
    }

    public function getReferenceType(): string
    {
        return 'document';
    }
}
