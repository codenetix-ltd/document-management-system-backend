<?php

namespace App\Services\Document;

use App\Contracts\Repositories\IDocumentVersionRepository;
use App\DocumentVersion;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class DocumentVersionService
{
    /**
     * @var IDocumentVersionRepository
     */
    private $repository;

    public function __construct(IDocumentVersionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function get($id): DocumentVersion
    {
        return $this->repository->findOrFail($id);
    }

    public function delete($id): ?bool
    {
        return $this->repository->delete($this->get($id));
    }

    public function create(DocumentVersion $documentVersion): DocumentVersion
    {
        $id = $this->repository->save($documentVersion);
        $documentVersion->setId($id);
        return $documentVersion;
    }
}
