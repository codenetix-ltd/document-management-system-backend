<?php

namespace App\Services\Document;

use App\Contracts\Repositories\IAttributeValueRepository;
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

    public function delete($id): ?bool
    {
        return $this->repository->delete($this->get($id));
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
}
