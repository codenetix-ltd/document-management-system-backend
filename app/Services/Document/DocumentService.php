<?php

namespace App\Services\Document;

use App\Contracts\Repositories\IDocumentRepository;
use App\Document;

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
            $this->documentVersionService->create($actualVersion);
        }

        $document->setId($id);

        return $document;
    }

    public function get($id): Document
    {
        return $this->repository->findOrFail($id);
    }

    public function update(int $id, Document $documentInput, $updatedFields): Document
    {
        $document = $this->get($id);

        //TODO - remove, refactoring
        foreach ($updatedFields as $fieldKey) {
            $document->{dms_build_setter($fieldKey)}($documentInput->{dms_build_getter($fieldKey)}());
        }

        $this->repository->save($document);

        return $document;
    }

    public function delete(int $id): ?bool
    {
        return $this->repository->delete($this->get($id));
    }

}
