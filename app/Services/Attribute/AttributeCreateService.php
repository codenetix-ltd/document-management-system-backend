<?php

namespace App\Services\Attribute;

use App\Contracts\Models\IAttribute;
use App\Contracts\Repositories\IAttributeRepository;
use App\Contracts\Repositories\ITypeRepository;
use App\Contracts\Services\Attribute\IAttributeCreateService;
use App\Contracts\Services\Attribute\IAttributeGetService;
use App\Exceptions\AttributeCreateFailException;
use App\Exceptions\UnsupportedAttributeTypeException;
use App\Exceptions\ValidationAttributeDataStructureException;
use App\Repositories\TransactionTrait;
use App\Services\Type\TypeService;
use Exception;

class AttributeCreateService implements IAttributeCreateService
{
    use TransactionTrait;

    private $repository;
    private $typeRepository;
    private $attributeGetService;

    public function __construct(IAttributeRepository $repository, ITypeRepository $typeRepository, IAttributeGetService $attributeGetService)
    {
        $this->repository = $repository;
        $this->typeRepository = $typeRepository;
        $this->attributeGetService = $attributeGetService;
    }

    /**
     * @param IAttribute $attribute
     * @param int $templateId
     * @return IAttribute
     * @throws AttributeCreateFailException
     * @throws UnsupportedAttributeTypeException
     * @throws ValidationAttributeDataStructureException
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
     * @throws AttributeCreateFailException
     * @throws UnsupportedAttributeTypeException
     * @throws ValidationAttributeDataStructureException
     */
    private function createComplexAttribute(IAttribute $attribute): IAttribute
    {
        $type = $this->typeRepository->getTypeById($attribute->getTypeId());
        if ($type->getMachineName() == TypeService::TYPE_TABLE) {
            return $this->createAttributeWithTableType($attribute);
        } else {
            //todo - catch
            throw new UnsupportedAttributeTypeException('Unsupported attribute type');
        }
    }

    /**
     * @param IAttribute $attribute
     * @return IAttribute
     * @throws AttributeCreateFailException
     * @throws ValidationAttributeDataStructureException
     */
    private function createAttributeWithTableType(IAttribute $attribute): IAttribute
    {
        $this->validationDataStructureForTableType($attribute->getData());

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
            //todo - catch
            throw new AttributeCreateFailException('The process of creating the attribute failed with an error', $e->getCode(), $e);
        }

        return $parentAttribute;
    }

    /**
     * @param array $data
     * @return bool
     * @throws ValidationAttributeDataStructureException
     */
    private function validationDataStructureForTableType(array $data): bool
    {
        //todo - catch
        if (!key_exists('headers', $data)) {
            throw new ValidationAttributeDataStructureException('Headers properties not found');
        }
        if (!is_array($data['headers']) || count($data['headers']) === 0) {
            throw new ValidationAttributeDataStructureException('Headers properties is empty');
        }
        if (!key_exists('rows', $data)) {
            throw new ValidationAttributeDataStructureException('Rows properties not found');
        }
        if (!is_array($data['rows']) || count($data['rows']) === 0) {
            throw new ValidationAttributeDataStructureException('Rows properties is empty');
        }

        $availableTypeIds = $this->typeRepository->getTypeIds();
        $totalColumns = count($data['headers']);
        array_walk($data['rows'], function ($item) use ($totalColumns, $availableTypeIds) {
            if (count($item['columns']) !== $totalColumns) {
                throw new ValidationAttributeDataStructureException('Bad data structure');
            }

            array_walk($item['columns'], function($item) use ($availableTypeIds) {
                if (!key_exists('typeId', $item) || !in_array($item['typeId'], $availableTypeIds)) {
                    throw new UnsupportedAttributeTypeException('Unsupported attribute type');
                }
            });
        });

        return true;
    }

    private function generateNameForCell(int $row, int $column, int $templateId)
    {
        return $row . '*' . $column . '*' . $templateId;
    }

    private function createTableTypeColumns(array $headers, int $parentAttributeId)
    {
        return array_map(function ($item) use ($parentAttributeId) {
            return $this->repository->createTableTypeColumn($parentAttributeId, $item['name']);
        }, $headers);
    }
}