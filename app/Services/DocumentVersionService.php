<?php

namespace App\Services;

use App\Entities\Document;
use App\Entities\DocumentVersion;
use App\Repositories\DocumentVersionRepository;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
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
     * @param AttributeValueService $attributeValueService
     */
    public function __construct(DocumentVersionRepository $repository, AttributeValueService $attributeValueService)
    {
        $this->repository = $repository;
        $this->attributeValueService = $attributeValueService;
    }

    /**
     * @param $documentId
     * @return mixed
     */
    public function list($documentId){
        return $this->repository->paginateByDocument($documentId);
    }

    /**
     * @param int $id
     * @return DocumentVersion
     */
    public function find(int $id){
        return $this->repository->find($id);
    }

    /**
     * @param array $data
     * @param int $documentId
     * @param string $versionName
     * @param bool $isActual
     *
     * @return DocumentVersion
     */
    public function create(array $data, $documentId, $versionName, $isActual){
        $data['documentId'] = $documentId;
        $data['versionName'] = $versionName;
        $data['isActual'] = $isActual;

        /** @var DocumentVersion $documentVersion */
        $documentVersion = $this->repository->create($data);
        $documentVersion->files()->sync($data['fileIds']);
        $documentVersion->labels()->sync($data['labelIds']);
        foreach($data['attributeValues'] as $attributeValue) {
            $this->attributeValueService->create([
                'attributeId' => $attributeValue['id'],
                'documentVersionId' => $documentVersion->id,
                'value' => $attributeValue['value']
            ]);
        }

        return $documentVersion;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id){
        /** @var DocumentVersion $documentVersion */
        $documentVersion = $this->repository->update($data, $id);

        $documentVersion->files()->sync($data['fileIds']);
        $documentVersion->labels()->sync($data['labelIds']);

        $documentVersion->attributeValues()->delete();

        foreach($data['attributeValues'] as $attributeValue) {
            $this->attributeValueService->create([
                'attributeId' => $attributeValue['id'],
                'documentVersionId' => $documentVersion->id,
                'value' => $attributeValue['value']
            ]);
        }

        return $documentVersion;
    }

    public function updateActual($actual, $id) {
        return $this->repository->update(['isActual' => $actual], $id);
    }

    /**
     * @param int $id
     */
    public function delete(int $id){
        $dv = $this->repository->findWhere([['id', '=', $id]])->first();
        if (is_null($dv)) {
            return;
        }

        $this->repository->delete($id);
    }
}