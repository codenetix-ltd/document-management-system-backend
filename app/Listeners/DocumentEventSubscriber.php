<?php

namespace App\Listeners;

use App\Events\Document\BulkDocumentArchiveEvent;
use App\Events\Document\BulkDocumentDeleteEvent;
use App\Events\Document\DocumentArchiveEvent;
use App\Events\Document\DocumentCreateEvent;
use App\Events\Document\DocumentDeleteEvent;
use App\Events\Document\DocumentUpdateEvent;
use Illuminate\Events\Dispatcher;

class DocumentEventSubscriber extends AEventSubscriber
{
    private $referenceType = 'document';

    public function onDocumentCreate(DocumentCreateEvent $event)
    {
        $this->logger->write($event->userSubject, 'create', $event->document->id, $this->referenceType);
    }

    public function onDocumentUpdate(DocumentUpdateEvent $event)
    {
        $this->logger->write($event->userSubject, 'update', $event->document->id, $this->referenceType);
    }

    public function onDocumentDelete(DocumentDeleteEvent $event)
    {
        $this->logger->write($event->userSubject, 'delete', $event->document->id, $this->referenceType);
    }

    public function onDocumentArchive(DocumentArchiveEvent $event)
    {
        $this->logger->write($event->userSubject, 'archive', $event->document->id, $this->referenceType);
    }

    public function onBulkDocumentDelete(BulkDocumentDeleteEvent $event)
    {
        foreach ($event->documentIds as $documentId) {
            $this->logger->write($event->userSubject, 'delete', $documentId, $this->referenceType);
        }
    }

    public function onBulkDocumentArchive(BulkDocumentArchiveEvent $event)
    {
        foreach ($event->documentIds as $documentId) {
            $this->logger->write($event->userSubject, 'archive', $documentId, $this->referenceType);
        }
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\Document\DocumentCreateEvent',
            'App\Listeners\DocumentEventSubscriber@onDocumentCreate'
        );

        $events->listen(
            'App\Events\Document\DocumentUpdateEvent',
            'App\Listeners\DocumentEventSubscriber@onDocumentUpdate'
        );

        $events->listen(
            'App\Events\Document\DocumentDeleteEvent',
            'App\Listeners\DocumentEventSubscriber@onDocumentDelete'
        );

        $events->listen(
            'App\Events\Document\DocumentArchiveEvent',
            'App\Listeners\DocumentEventSubscriber@onDocumentArchive'
        );

        $events->listen(
            'App\Events\Document\BulkDocumentDeleteEvent',
            'App\Listeners\DocumentEventSubscriber@onBulkDocumentDelete'
        );
        $events->listen(
            'App\Events\Document\BulkDocumentArchiveEvent',
            'App\Listeners\DocumentEventSubscriber@onBulkDocumentArchive'
        );

    }
}
