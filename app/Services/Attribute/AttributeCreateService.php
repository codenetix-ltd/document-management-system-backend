<?php

namespace App\Services\Attribute;

use App\Contracts\Models\IAttribute;
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
     * @param IAttribute $attribute
     * @param int $templateId
     * @return IAttribute
     * @throws FailedAttributeCreateException
     * @throws InvalidAttributeTypeException
     * @throws InvalidAttributeDataStructureException
     */
    public function create(IAttribute $attribute, int $templateId) : IAttribute
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
     * @param IAttribute $attribute
     * @return IAttribute
     * @throws FailedAttributeCreateException
     * @throws InvalidAttributeTypeException
     * @throws InvalidAttributeDataStructureException
     */
    private function createComplexAttribute(IAttribute $attribute): IAttribute
    {
        $type = $this->typeRepository->getTypeById($attribute->getTypeId());
        if ($type->getMachineName() == TypeService::TYPE_TABLE) {
            return $this->createAttributeWithTableType($attribute);
        } else {
            throw new InvalidAttributeTypeException('Unsupported attribute type');
        }
    }

    /**
     * @param IAttribute $attribute
     * @return IAttribute
     * @throws FailedAttributeCreateException
     * @throws InvalidAttributeDataStructureException
     */
    private function createAttributeWithTableType(IAttribute $attribute): IAttribute
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
                    /** @var IAttribute $childAttribute */
                    $childAttribute = app()->make(IAttribute::class);
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