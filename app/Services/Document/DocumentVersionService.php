<?php

namespace App\Services\Document;

use App\Contracts\Repositories\IAttributeValueRepository;
use App\Contracts\Repositories\IDocumentVersionRepository;
use App\DocumentVersion;
use App\Exceptions\FailedDeleteActualDocumentVersion;
use Illuminate\Support\Collection;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class DocumentVersionService
{
    /**
     * @var IDocumentVersionRepository
     */
    private $repository;
    /**
     * @var IAttributeValueRepository
     */
    private $attributeValueRepository;

    public function __construct(IDocumentVersionRepository $repository, IAttributeValueRepository $attributeValueRepository)
    {
        $this->repository = $repository;
        $this->attributeValueRepository = $attributeValueRepository;
    }

    public function get($id): DocumentVersion
    {
        return $this->repository->findOrFail($id);
    }

    /**
     * @param $id
     *
     * @param bool $force
     * @return bool|null
     * @throws FailedDeleteActualDocumentVersion
     */
    public function delete($id, $force = false): ?bool
    {
        $version = $this->get($id);

        if(!$force && $version->isActual()) {
            throw new FailedDeleteActualDocumentVersion();
        }

        return $this->repository->delete($version);
    }

    public function create(DocumentVersion $documentVersion): DocumentVersion
    {
        $id = $this->repository->save($documentVersion);
        $documentVersion->setId($id);

        if (count($documentVersion->getLabelIds())) {
            $this->repository->syncTags($documentVersion, $documentVersion->getLabelIds());
        } else {
            $this->repository->detachTags($documentVersion);
        }

        if (count($documentVersion->getFileIds())) {
            $this->repository->syncFiles($documentVersion, $documentVersion->getFileIds());
        } else {
            $this->repository->detachFiles($documentVersion);
        }

        if (count($documentVersion->getAttributeValues())) {
            foreach($documentVersion->getAttributeValues() as $attributeValue) {
                $attributeValue->setDocumentVersionId($id);
                $this->attributeValueRepository->save($attributeValue);
            }
        }

        return $documentVersion;
    }

    public function update(DocumentVersion $documentVersion): DocumentVersion
    {
        $this->repository->save($documentVersion);

        return $documentVersion;
    }

    public function list(int $documentId): Collection
    {
        $versions = $this->repository->list($documentId);
        /**
         * TODO why is it necessary to use get method? it makes n queries to database
         * @see \App\Services\Attribute\AttributeService::list()
         */
        $versions->transform(function ($version) {
            /** @var DocumentVersion $version */
            return $this->get($version->getId());
        });

        return $versions;
    }
}
