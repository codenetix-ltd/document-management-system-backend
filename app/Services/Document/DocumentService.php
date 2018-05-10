<?php

namespace App\Services\Document;

use App\Contracts\Repositories\IDocumentRepository;
use App\Document;
use App\DocumentVersion;
use App\Events\Document\DocumentCreateEvent;
use App\Events\Document\DocumentDeleteEvent;
use App\Events\Document\DocumentReadEvent;
use App\Events\Document\DocumentUpdateEvent;
use App\Services\Components\IEventDispatcher;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class DocumentService
{
    private $repository;
    /**
     * @var DocumentVersionService
     */
    private $documentVersionService;
    /**
     * @var IEventDispatcher
     */
    private $eventDispatcher;

    /**
     * DocumentService constructor.
     *
     * @param IDocumentRepository $repository
     * @param DocumentVersionService $documentVersionService
     * @param IEventDispatcher $eventDispatcher
     */
    public function __construct(
        IDocumentRepository $repository,
        DocumentVersionService $documentVersionService,
        IEventDispatcher $eventDispatcher
    )
    {
        $this->repository = $repository;
        $this->documentVersionService = $documentVersionService;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function create(Document $document): Document
    {
        $id = $this->doCreate($document);
        $document->setId($id);

        $this->eventDispatcher->dispatch(new DocumentCreateEvent($document));

        return $document;
    }

    /**
     * @param Document $document
     *
     * @return int
     */
    protected function doCreate(Document $document): int
    {
        $id = $this->repository->save($document);

        if($document->getActualVersion()) {
            $actualVersion = $document->getActualVersion();
            $actualVersion->setDocumentId($id);
            $actualVersion->setVersionName(1);
            $actualVersion->setActual(true);
            $this->documentVersionService->create($actualVersion);
        }

        return $id;
    }

    public function get($id): Document
    {
        $document = $this->repository->findOrFail($id);
        $this->eventDispatcher->dispatch(new DocumentReadEvent($document));

        return $document;
    }

    public function update(int $id, Document $documentInput, $updatedFields, bool $createNewVersion = true): Document
    {
        $document = $this->get($id);

        foreach ($updatedFields as $fieldKey) {
            $document->{dms_build_setter($fieldKey)}($documentInput->{dms_build_getter($fieldKey)}());
        }

        $newActualVersion = $documentInput->getActualVersion();

        if($newActualVersion) {
            $oldActualVersion = $this->repository->getActualVersionRelation($document);
            $newActualVersion->setDocumentId($id);
            $newActualVersion->setActual(true);

            $this->doUpdate($document, $oldActualVersion, $newActualVersion, $createNewVersion);
        } else {
            $this->doUpdate($document, null, null, false);
        }

        $this->eventDispatcher->dispatch(new DocumentUpdateEvent($document));
        return $this->get($id);
    }

    protected function doUpdate(Document $document, ?DocumentVersion $oldActualVersion, ?DocumentVersion $newActualVersion, bool $createNewVersion): void
    {
        $this->repository->save($document);

        if($newActualVersion && $oldActualVersion) {
            if ($createNewVersion) {
                $oldActualVersion->setActual(false);
                $this->documentVersionService->update($oldActualVersion);
                $newActualVersion->setVersionName((int)$oldActualVersion->getVersionName() + 1);
            } else {
                $this->documentVersionService->delete($oldActualVersion->getId(), true);
                $newActualVersion->setVersionName($oldActualVersion->getVersionName());
            }
            $this->documentVersionService->create($newActualVersion);
        }

    }

    public function delete(int $id): ?bool
    {
        $document = $this->repository->find($id);

        if(!$document) {
            return false;
        }

        $this->eventDispatcher->dispatch(new DocumentDeleteEvent($document));
        return $this->repository->delete($document);
    }

    public function list(array $filters): LengthAwarePaginator
    {
        return $this->repository->list($filters);
    }

    public function setActualVersion($documentId, $documentVersionId)
    {
        $document = $this->get($documentId);
        $newDV = $this->documentVersionService->get($documentVersionId);

        if ($newDV->getDocumentId() != $documentId) {
            throw (new ModelNotFoundException())->setModel(DocumentVersion::class);
        }

        $oldDV = $this->repository->getActualVersionRelation($document);
        $oldDV->setActual(false);
        $newDV->setActual(true);

        $this->doSetActualVersion($oldDV, $newDV);

        return $this->get($documentId);
    }

    protected function doSetActualVersion($oldDV, $newDV)
    {
        $this->documentVersionService->update($oldDV);
        $this->documentVersionService->update($newDV);
    }
}
