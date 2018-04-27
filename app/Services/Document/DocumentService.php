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
        $id = $this->repository->save($document);

        if($document->getActualVersion()) {
            $actualVersion = $document->getActualVersion();
            $actualVersion->setDocumentId($id);
            $actualVersion->setVersionName(1);
            $actualVersion->setActual(true);
            $this->documentVersionService->create($actualVersion);
        }

        $document->setId($id);

        return $document;
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

        $this->repository->save($document);

        $oldActualVersion = $this->repository->getActualVersionRelation($document);
        $newActualVersion = $documentInput->getActualVersion();
        $newActualVersion->setDocumentId($id);
        $newActualVersion->setActual(true);

        if($createNewVersion) {
            $oldActualVersion->setActual(false);
            $this->documentVersionService->update($oldActualVersion);
            $newActualVersion->setVersionName((int)$oldActualVersion->getVersionName() + 1);
        } else {
            $this->documentVersionService->delete($oldActualVersion->getId());
            $newActualVersion->setVersionName($oldActualVersion->getVersionName());
        }

        $this->documentVersionService->create($newActualVersion);

        return $this->get($id);
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
