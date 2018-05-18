<?php

namespace App\Services;

use App\Entities\Attribute;
use App\Repositories\AttributeRepository;
use App\Repositories\TypeRepository;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
class AttributeService
{
    /**
     * @var AttributeRepository
     */
    protected $repository;

    protected $typeRepository;

    /**
     * AttributeService constructor.
     * @param AttributeRepository $repository
     */
    public function __construct(AttributeRepository $repository, TypeRepository $typeRepository)
    {
        $this->repository = $repository;
        $this->typeRepository = $typeRepository;
    }

    /**
     * @return mixed
     */
    public function list()
    {
        return $this->repository->all();
    }

    /**
     * @param int $id
     * @return Attribute
     */
    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param $templateId
     * @param array $data
     * @return mixed
     */
    public function create($templateId, array $data)
    {
        $data['templateId'] = $templateId;
        $data['order'] = $this->getDefaultAttributeOrderByTemplateId($templateId);

        if (empty($data['data'])) {
            $attribute = $this->repository->create($data);
        } else {
            dd(123);
            $attribute = $this->createComplexAttribute($data);
        }

        return $this->repository->find($attribute->id);
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id)
    {
        return $this->repository->update($data, $id);
    }

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
        $this->repository->delete($id);
    }

    public function paginate()
    {
        return $this->repository->paginate();
    }

    private function getDefaultAttributeOrderByTemplateId($templateId): int
    {
        $maxOrder = $this->repository->findWhere([
            ['template_id', '=', $templateId],
            ['parent_attribute_id', '=', null]
        ])->max('order');

        if (is_null($maxOrder)) {
            return 0;
        } else {
            return $maxOrder + 1;
        }
    }

    public function buildData(Attribute $attribute): ?array
    {
        $type = $this->typeRepository->find($attribute->getTypeId());
        if ($type->getMachineName() == TypeService::TYPE_TABLE) {
            return $this->buildDataForTable($attribute->getId());
        }

        return null;
    }
}