<?php

namespace App\Services;

use App\Entities\DocumentVersion;
use App\Exceptions\FailedDeleteActualDocumentVersion;
use App\Repositories\DocumentVersionRepository;

class DocumentVersionService
{
    /**
     * @var DocumentVersionRepository
     */
    protected $repository;
    /**
     * @var AttributeValueService
     */
    private $attributeValueService;

    /**
     * DocumentVersionService constructor.
     * @param DocumentVersionRepository $repository
     * @param AttributeValueService     $attributeValueService
     */
    public function __construct(DocumentVersionRepository $repository, AttributeValueService $attributeValueService)
    {
        $this->repository = $repository;
        $this->attributeValueService = $attributeValueService;
    }

    /**
     * @param integer $documentId
     * @param bool $withCriteria
     * @return mixed
     */
    public function list(int $documentId, $withCriteria = false)
    {
        return $this->repository->paginateByDocument($documentId, $withCriteria);
    }

    /**
     * @param integer $id
     * @return DocumentVersion
     */
    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param array   $data
     * @param integer $documentId
     * @param string  $versionName
     * @param boolean $isActual
     *
     * @return DocumentVersion
     */
    public function create(array $data, int $documentId, string $versionName, bool $isActual)
    {
        $data['documentId'] = $documentId;
        $data['versionName'] = $versionName;
        $data['isActual'] = $isActual;

        /** @var DocumentVersion $documentVersion */
        $documentVersion = $this->repository->create($data);
        $documentVersion->files()->sync($data['fileIds']);
        $documentVersion->labels()->sync($data['labelIds']);

        foreach ($data['attributeValues'] as $attributeValue) {
            $this->attributeValueService->create([
                'attributeId' => $attributeValue['id'],
                'documentVersionId' => $documentVersion->id,
                'value' => $attributeValue['value']
            ]);
        }

        return $documentVersion;
    }

    /**
     * @param array   $data
     * @param integer $id
     * @return DocumentVersion
     */
    public function update(array $data, int $id)
    {
        /** @var DocumentVersion $documentVersion */
        $documentVersion = $this->repository->update($data, $id);

        $documentVersion->files()->sync($data['fileIds']);
        $documentVersion->labels()->sync($data['labelIds']);

        $documentVersion->attributeValues()->delete();

        foreach ($data['attributeValues'] as $attributeValue) {
            $this->attributeValueService->create([
                'attributeId' => $attributeValue['id'],
                'documentVersionId' => $documentVersion->id,
                'value' => $attributeValue['value']
            ]);
        }

        return $documentVersion;
    }

    /**
     * @param boolean $actual
     * @param integer $id
     * @return DocumentVersion
     */
    public function updateActual(bool $actual, int $id)
    {
        return $this->repository->update(['isActual' => $actual], $id);
    }

    /**
     * @param int $id
     * @param bool $force
     * @throws FailedDeleteActualDocumentVersion
     */
    public function delete(int $id, bool $force = false)
    {
        $documentVersion = $this->repository->find($id);

        if ($documentVersion->isActual && !$force) {
            throw new FailedDeleteActualDocumentVersion('Actual version cannot be deleted');
        }

        $this->repository->delete($id);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function findModel(int $id)
    {
        return $this->repository->findModel($id);
    }
}
