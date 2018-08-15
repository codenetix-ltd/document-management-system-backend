<?php

namespace App\Services;

use App\QueryParams\IQueryParamsObject;
use App\Entities\DocumentVersion;
use App\Exceptions\FailedDeleteActualDocumentVersion;
use App\Repositories\DocumentVersionRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DocumentVersionService
{
    use CRUDServiceTrait;

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
        $this->attributeValueService = $attributeValueService;

        $this->setRepository($repository);
    }

    /**
     * @param IQueryParamsObject $queryParamsObject
     * @param integer            $documentId
     * @return mixed
     */
    public function list(IQueryParamsObject $queryParamsObject, int $documentId)
    {
        return $this->repository->paginateByDocumentId($queryParamsObject, $documentId);
    }

    /**
     * Generates next version name for specified document id
     * @param integer $documentId
     * @param boolean $increment
     * @return integer
     */
    public function generateVersionNameByDocumentId(int $documentId, bool $increment)
    {
        $latestDocumentVersion = $this->repository->latestVersionByDocumentId($documentId);
        return $latestDocumentVersion ? (int)$latestDocumentVersion->versionName + ($increment ? 1 : 0) : 1;
    }

    /**
     * @param array   $data
     * @param boolean $isActual
     * @param boolean $incrementVersion
     * @return DocumentVersion
     */
    public function create(array $data, bool $isActual, bool $incrementVersion = true)
    {
        $data['isActual'] = $isActual;
        $data['versionName'] = $this->generateVersionNameByDocumentId($data['documentId'], $incrementVersion);

        $this->repository->all();

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
     * @param integer $id
     * @param boolean $force
     * @return void
     * @throws FailedDeleteActualDocumentVersion
     */
    public function delete(int $id, bool $force = false)
    {
        try {
            $documentVersion = $this->repository->find($id);
        } catch (ModelNotFoundException $e) {
            return;
        }

        if ($documentVersion->isActual && !$force) {
            throw new FailedDeleteActualDocumentVersion('Actual version cannot be deleted');
        }

        $this->repository->delete($id);
    }
}
