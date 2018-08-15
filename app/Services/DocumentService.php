<?php

namespace App\Services;

use App\QueryParams\IQueryParamsObject;
use App\Entities\Document;
use App\Entities\DocumentVersion;
use App\Events\Document\DocumentCreateEvent;
use App\Events\Document\DocumentDeleteEvent;
use App\Events\Document\DocumentReadEvent;
use App\Events\Document\DocumentUpdateEvent;
use App\Repositories\DocumentRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Event;

class DocumentService
{
    use CRUDServiceTrait;

    /**
     * @var DocumentVersionService
     */
    private $documentVersionService;

    /**
     * DocumentService constructor.
     * @param DocumentRepository     $repository
     * @param DocumentVersionService $documentVersionService
     */
    public function __construct(DocumentRepository $repository, DocumentVersionService $documentVersionService)
    {
        $this->setRepository($repository);
        $this->setModelGetEventClass(DocumentReadEvent::class);
        $this->setModelDeleteEventClass(DocumentDeleteEvent::class);
        $this->documentVersionService = $documentVersionService;
    }

    /**
     * @param array $data
     * @return Document
     */
    public function create(array $data)
    {
        /** @var Document $document */
        $document = $this->repository->create($data);

        $data['actualVersion']['documentId'] = $document->id;
        $this->documentVersionService->create($data['actualVersion'], true);
        Event::dispatch(new DocumentCreateEvent($document));

        return $document;
    }

    /**
     * @param array   $data
     * @param integer $id
     * @return Document
     */
    public function update(array $data, int $id)
    {
        /** @var Document $document */
        $document = $this->repository->update($data, $id);

        if (isset($data['actualVersionId'])) {
            $this->setActualVersion($document->id, $data['actualVersionId']);
        }

        Event::dispatch(new DocumentUpdateEvent($document));

        return $document;
    }

    /**
     * @param array   $data
     * @param integer $id
     * @return Document
     * @throws \App\Exceptions\FailedDeleteActualDocumentVersion
     */
    public function updateVersion(array $data, int $id)
    {
        $createNewVersion = $data['createNewVersion'];
        $document = $this->find($id);
        $oldActualVersion = $document->documentActualVersion;

        $data['actualVersion']['documentId'] = $document->id;
        $this->documentVersionService->create(
            $data['actualVersion'],
            true,
            $createNewVersion
        );

        if ($createNewVersion) {
            $this->documentVersionService->updateActual(false, $oldActualVersion->id);
        } else {
            $this->documentVersionService->delete($oldActualVersion->id, true);
        }

        return $this->update($data, $id);
    }

    /**
     * @param integer $documentId
     * @param integer $versionId
     * @return void
     */
    public function setActualVersion(int $documentId, int $versionId): void
    {
        $document = $this->find($documentId);
        $newVersion = $this->documentVersionService->find($versionId);

        if ($newVersion->documentId != $documentId) {
            throw (new ModelNotFoundException())->setModel(DocumentVersion::class);
        }

        $oldVersion = $document->documentActualVersion;

        $this->documentVersionService->updateActual(false, $oldVersion->id);
        $this->documentVersionService->updateActual(true, $newVersion->id);
    }
}
