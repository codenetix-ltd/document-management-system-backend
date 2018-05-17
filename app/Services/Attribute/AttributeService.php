<?php

namespace App\Services\Attribute;

use App\Attribute;
use App\Contracts\Repositories\IAttributeRepository;
use App\Contracts\Repositories\ITypeRepository;
use App\Exceptions\FailedAttributeCreateException;
use App\Exceptions\FailedAttributeDeleteException;
use App\Exceptions\InvalidAttributeTypeException;
use App\Exceptions\InvalidAttributeDataStructureException;
use App\Services\Type\TypeService;
use App\TableTypeColumn;
use App\TableTypeRow;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class AttributeService {
    private $repository;
    private $typeRepository;

    public function __construct(IAttributeRepository $repository, ITypeRepository $typeRepository)
    {
        $this->repository = $repository;
        $this->typeRepository = $typeRepository;
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
        $attribute->setOrder($this->repository->getDefaultAttributeOrderByTemplateId($attribute->getTemplateId()));

        if (!$attribute->getData()) {
            $attribute = $this->repository->create($attribute);
        } else {
            $attribute = $this->createComplexAttribute($attribute);
        }

        return $this->get($attribute->getId());
    }

    /**
     * @param int $id
     * @return bool|null
     * @throws FailedAttributeDeleteException
     */
    public function delete(int $id): ?bool
    {
        $attribute = $this->repository->find($id);
        if (is_null($attribute)) {
            return null;
        }

        if ($attribute->getParentAttributeId()) {
            throw new FailedAttributeDeleteException('Removing an attribute that has a parent attribute is not possible');
        } else {
            return $this->repository->delete($id);
        }
    }

    public function get(int $id): Attribute
    {
        $attribute = $this->repository->findOrFail($id);
        $attribute->setData($this->buildData($attribute));

        return $attribute;
    }

    public function list(int $templateId): Collection
    {
        $attributes = $this->repository->list($templateId);
        //TODO why is it necessary to use get method? it makes n queries to database
        $attributes->transform(function ($attribute) {
            /** @var Attribute $attribute */
            return $this->get($attribute->getId());
        });

        return $attributes;
    }

    //TODO - Move validation in request
    /**
     * @param Attribute $attribute
     * @return bool
     * @throws InvalidAttributeDataStructureException
     */
    private function validateTable(Attribute $attribute): bool
    {
        $data = $attribute->getData();

        if (!key_exists('headers', $data)) {
            throw new InvalidAttributeDataStructureException('Headers properties not found');
        }
        if (!is_array($data['headers']) || count($data['headers']) === 0) {
            throw new InvalidAttributeDataStructureException('Headers properties is empty');
        }
        if (!key_exists('rows', $data)) {
            throw new InvalidAttributeDataStructureException('Rows properties not found');
        }
        if (!is_array($data['rows']) || count($data['rows']) === 0) {
            throw new InvalidAttributeDataStructureException('Rows properties is empty');
        }

        //TODO REMOVE getTypeIds => USE ANOTHER METHOD FOR GETTING TYPE IDS
        $availableTypeIds = $this->typeRepository->getTypeIds();
        $totalColumns = count($data['headers']);
        array_walk($data['rows'], function ($item) use ($totalColumns, $availableTypeIds) {
            if (count($item['columns']) !== $totalColumns) {
                throw new InvalidAttributeDataStructureException('Bad data structure');
            }

            array_walk($item['columns'], function($item) use ($availableTypeIds) {
                if (!key_exists('typeId', $item) || !in_array($item['typeId'], $availableTypeIds)) {
                    throw new InvalidAttributeTypeException('Unsupported attribute type');
                }
            });
        });

        return true;
    }

    private function buildData(Attribute $attribute): ?array
    {
        $type = $this->typeRepository->find($attribute->getTypeId());
        if ($type->getMachineName() == TypeService::TYPE_TABLE) {
            return $this->buildDataForTable($attribute->getId());
        }

        return null;
    }

    private function buildDataForTable(int $id): array
    {
        $rows = $this->repository->getTableRowsByAttributeId($id);
        $columns = $this->repository->getTableColumnsByAttributeId($id);
        $childAttributes = $this->repository->getChildAttributes($id);

        $data = [];
        /** @var TableTypeRow $row */
        foreach ($rows as $row) {
            $dataRow['name'] = $row->getName();
            $dataRow['columns'] = [];
            /** @var TableTypeColumn $column */
            foreach ($columns as $column) {
                /** @var Attribute $childAttribute */
                foreach ($childAttributes as $childAttribute) {
                    if ($childAttribute->getTableTypeRowId() == $row->getId() && $childAttribute->getTableTypeColumnId() == $column->getId()) {
                        $dataRow['columns'][] = [
                            //todo - refactoring, create special objects
                            'typeId' => $childAttribute->getTypeId(),
                            'isLocked' => $childAttribute->isLocked()
                        ];
                    }
                }
            }
            $data['rows'][] = $dataRow;
        }

        foreach ($columns as $column) {
            $data['headers'][] = ['name' => $column->getName()];
        }

        return $data;
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
        $type = $this->typeRepository->find($attribute->getTypeId());

        //TODO - create factory for different types
        if ($type->getMachineName() == TypeService::TYPE_TABLE) {
            $this->validateTable($attribute);
            return $this->createAttributeWithTableType($attribute);
        } else {
            throw new InvalidAttributeTypeException('Unsupported attribute type');
        }
    }

    /**
     * @param Attribute $attribute
     * @return Attribute
     * @throws FailedAttributeCreateException
     */
    protected function createAttributeWithTableType(Attribute $attribute): Attribute
    {
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
        } catch (Exception $e) {
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
