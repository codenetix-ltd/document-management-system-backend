<?php

namespace App\Services\Attribute;

use App\Attribute;
use App\Contracts\Repositories\IAttributeRepository;
use App\Contracts\Repositories\ITypeRepository;
use App\Contracts\Services\Attribute\IAttributeCreateService;
use App\Contracts\Services\Attribute\IAttributeGetService;
use App\Contracts\Services\Attribute\IAttributeTypeTableValidator;
use App\Exceptions\FailedAttributeCreateException;
use App\Exceptions\InvalidAttributeTypeException;
use App\Exceptions\InvalidAttributeDataStructureException;
use App\Repositories\TransactionTrait;
use App\Services\Type\TypeService;
use Exception;

class AttributeCreateService implements IAttributeCreateService
{
    use TransactionTrait;

    private $repository;
    private $typeRepository;
    private $attributeGetService;
    private $attributeTypeTableValidator;

    public function __construct(IAttributeRepository $repository, ITypeRepository $typeRepository, IAttributeGetService $attributeGetService, IAttributeTypeTableValidator $attributeTypeTableValidator)
    {
        $this->repository = $repository;
        $this->typeRepository = $typeRepository;
        $this->attributeGetService = $attributeGetService;
        $this->attributeTypeTableValidator = $attributeTypeTableValidator;
    }

    /**
     * @param Attribute $attribute
     * @param int $templateId
     * @return Attribute
     * @throws FailedAttributeCreateException
     * @throws InvalidAttributeTypeException
     * @throws InvalidAttributeDataStructureException
     */
    public function create(Attribute $attribute, int $templateId) : Attribute
    {
        $attribute->setTemplateId($templateId);

        if (!$attribute->getData()) {
            $attribute = $this->repository->create($attribute);
        } else {
            $attribute = $this->createComplexAttribute($attribute);
        }

        return $this->attributeGetService->get($attribute->getId());
    }

    /**
     * @param Attribute $attribute
     * @return Attribute
     * @throws FailedAttributeCreateException
     * @throws InvalidAttributeTypeException
     * @throws InvalidAttributeDataStructureException
     */
    private function createComplexAttribute(Attribute $attribute): Attribute
    {
        $type = $this->typeRepository->getTypeById($attribute->getTypeId());
        if ($type->getMachineName() == TypeService::TYPE_TABLE) {
            return $this->createAttributeWithTableType($attribute);
        } else {
            throw new InvalidAttributeTypeException('Unsupported attribute type');
        }
    }

    /**
     * @param Attribute $attribute
     * @return Attribute
     * @throws FailedAttributeCreateException
     * @throws InvalidAttributeDataStructureException
     */
    private function createAttributeWithTableType(Attribute $attribute): Attribute
    {
        $this->attributeTypeTableValidator->validate($attribute);

        $this->beginTransaction();
        try {
            $data = $attribute->getData();
            $parentAttribute = $this->repository->create($attribute);

            $columns = $this->createTableTypeColumns($data['headers'], $parentAttribute->getId());

            foreach ($data['rows'] as $rowKey => $rowValue) {
                $row = $this->repository->createTableTypeRow($parentAttribute->getId(), $rowValue['name']);

                foreach ($rowValue['columns'] as $columnKey => $columnValue) {
                    /** @var Attribute $childAttribute */
                    $childAttribute = app()->make(Attribute::class);
                    $childAttribute->setTypeId($columnValue['typeId']);
                    $childAttribute->setName($this->generateNameForCell($rowKey, $columnKey, $parentAttribute->getTemplateId()));
                    $childAttribute->setParentAttributeId($parentAttribute->getId());
                    $childAttribute->setTemplateId($parentAttribute->getTemplateId());
                    $childAttribute->setTableTypeRowId($row->getId());
                    $childAttribute->setTableTypeColumnId($columns[$columnKey]->getId());
                    $this->repository->create($childAttribute);
                }
            }
            $this->commit();
        } catch (Exception $e) {
            $this->rollback();
            throw new FailedAttributeCreateException('The process of creating the attribute failed with an error', $e->getCode(), $e);
        }

        return $parentAttribute;
    }

    private function generateNameForCell(int $row, int $column, int $templateId)
    {
        return 'row_' . $row . '*' . 'column_' . $column . '*' . 'template_' . $templateId;
    }

    private function createTableTypeColumns(array $headers, int $parentAttributeId)
    {
        return array_map(function ($item) use ($parentAttributeId) {
            return $this->repository->createTableTypeColumn($parentAttributeId, $item['name']);
        }, $headers);
    }
}