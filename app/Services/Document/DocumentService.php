<?php

namespace App\Services\Document;

use App\Contracts\Repositories\IDocumentRepository;
use App\Document;
use App\DocumentVersion;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
     * DocumentService constructor.
     *
     * @param IDocumentRepository $repository
     * @param DocumentVersionService $documentVersionService
     */
    public function __construct(IDocumentRepository $repository, DocumentVersionService $documentVersionService)
    {
        $this->repository = $repository;
        $this->documentVersionService = $documentVersionService;
    }

    public function create(Document $document): Document
    {
        $id = $this->doCreate($document);
        $document->setId($id);

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
        return $this->repository->findOrFail($id);
    }

    public function update(int $id, Document $documentInput, $updatedFields, bool $createNewVersion = true): Document
    {
        $document = $this->get($id);

        foreach ($updatedFields as $fieldKey) {
            $document->{dms_build_setter($fieldKey)}($documentInput->{dms_build_getter($fieldKey)}());
        }


        $oldActualVersion = $this->repository->getActualVersionRelation($document);
        $newActualVersion = $documentInput->getActualVersion();
        $newActualVersion->setDocumentId($id);
        $newActualVersion->setActual(true);

        $this->doUpdate($document, $oldActualVersion, $newActualVersion, $createNewVersion);

        return $this->get($id);
    }

    protected function doUpdate(Document $document, DocumentVersion $oldActualVersion, DocumentVersion $newActualVersion, bool $createNewVersion): void
    {
        $this->repository->save($document);
        if($createNewVersion) {
            $oldActualVersion->setActual(false);
            $this->documentVersionService->update($oldActualVersion);
            $newActualVersion->setVersionName((int)$oldActualVersion->getVersionName() + 1);
        } else {
            $this->documentVersionService->delete($oldActualVersion->getId());
            $newActualVersion->setVersionName($oldActualVersion->getVersionName());
        }

        $this->documentVersionService->create($newActualVersion);
    }

    public function delete(int $id): ?bool
    {
        return $this->repository->delete($this->get($id));
    }

    public function list(): LengthAwarePaginator
    {
        return $this->repository->list();
    }

}
