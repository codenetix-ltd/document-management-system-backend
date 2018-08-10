<?php

namespace App\Services;

use App\Criteria\IQueryParamsObject;
use App\Entities\Attribute;
use App\Entities\TableTypeColumn;
use App\Entities\TableTypeRow;
use App\Exceptions\FailedAttributeCreateException;
use App\Exceptions\FailedAttributeDeleteException;
use App\Exceptions\InvalidAttributeDataStructureException;
use App\Exceptions\InvalidAttributeTypeException;
use App\Repositories\AttributeRepository;
use App\Repositories\TypeRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AttributeService
{
    /**
     * @var AttributeRepository
     */
    protected $repository;

    /**
     * @var TypeRepository
     */
    protected $typeRepository;

    /**
     * AttributeService constructor.
     * @param AttributeRepository $repository
     * @param TypeRepository      $typeRepository
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
     * @param integer $id
     * @return Attribute
     */
    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param integer $templateId
     * @param array   $data
     * @return Attribute
     * @throws FailedAttributeCreateException
     * @throws InvalidAttributeDataStructureException
     * @throws InvalidAttributeTypeException
     */
    public function create(int $templateId, array $data)
    {
        $data['templateId'] = $templateId;
        $data['order'] = $this->getNextAttributeOrderByTemplateId($templateId);

        if (empty($data['data'])) {
            $attribute = $this->repository->create($data);
        } else {
            $attribute = $this->createComplexAttribute($data);
        }

        return $this->repository->find($attribute->id);
    }

    /**
     * @param integer $templateId
     * @param integer $id
     * @param array   $data
     * @return Attribute
     * @throws FailedAttributeCreateException
     * @throws InvalidAttributeDataStructureException
     * @throws InvalidAttributeTypeException
     */
    public function update(int $templateId, int $id, array $data)
    {
        if (empty($data['data'])) {
            $attribute = $this->repository->update($data, $id);
        } else {
            $attribute = $this->updateComplexAttribute($data, $id);
        }

        return $this->repository->find($attribute->id);
    }

    /**
     * @param integer $templateId
     * @param array   $ids
     * @return void
     */
    public function updateOrderOfAttributes(int $templateId, array $ids)
    {
        foreach ($ids as $attributeOrder => $attributeId) {
            try {
                $this->update($templateId, $attributeId, ['order' => $attributeOrder]);
            } catch (Exception $e) {
            }
        }
    }

    /**
     * @param IQueryParamsObject $queryParamsObject
     * @param integer $templateId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateAttributes(IQueryParamsObject $queryParamsObject, int $templateId)
    {
        return $this->repository->paginateAttributes($queryParamsObject, $templateId);
    }

    /**
     * @param integer $templateId
     * @return integer
     */
    private function getNextAttributeOrderByTemplateId(int $templateId): int
    {
        $maxOrder = $this->repository->getMaxOrderValueOfAttributeByTemplateId($templateId);

        return $maxOrder === null ? 0 : ($maxOrder + 1);
    }

    /**
     * @param Attribute $attribute
     * @return array|null
     */
    public function buildData(Attribute $attribute): ?array
    {
        $type = $this->typeRepository->find($attribute->typeId);
        if ($type->machineName == TypeService::TYPE_TABLE) {
            return $this->buildDataForTable($attribute->id);
        }

        return null;
    }

    /**
     * @param integer $id
     * @return array
     */
    private function buildDataForTable(int $id): array
    {
        $rows = $this->repository->getTableRowsByAttributeId($id);
        $columns = $this->repository->getTableColumnsByAttributeId($id);
        $childAttributes = $this->repository->getChildAttributes($id);

        $data = [];
        /** @var TableTypeRow $row */
        foreach ($rows as $row) {
            $dataRow['name'] = $row->name;
            $dataRow['columns'] = [];
            /** @var TableTypeColumn $column */
            foreach ($columns as $column) {
                /** @var Attribute $childAttribute */
                foreach ($childAttributes as $childAttribute) {
                    if ($childAttribute->tableTypeRowId == $row->id && $childAttribute->tableTypeColumnId == $column->id) {
                        $dataRow['columns'][] = [
                            'id' => $childAttribute->id,
                            'typeId' => $childAttribute->typeId,
                            'isLocked' => $childAttribute->isLocked
                        ];
                    }
                }
            }
            $data['rows'][] = $dataRow;
        }

        foreach ($columns as $column) {
            $data['headers'][] = ['name' => $column->name];
        }

        return $data;
    }

    /**
     * @param array $data
     * @return Attribute
     * @throws FailedAttributeCreateException
     * @throws InvalidAttributeDataStructureException
     * @throws InvalidAttributeTypeException
     */
    private function createComplexAttribute(array $data): Attribute
    {
        $type = $this->typeRepository->find($data['typeId']);

        if ($type->machine_name == TypeService::TYPE_TABLE) {
            $this->validateTable($data);
            return $this->createAttributeWithTableType($data);
        } else {
            throw new InvalidAttributeTypeException('Unsupported attribute type');
        }
    }

    /**
     * @param array $data
     * @return boolean
     * @throws InvalidAttributeDataStructureException
     */
    private function validateTable(array $data): bool
    {
        $tableData = $data['data'];

        if (!key_exists('headers', $tableData)) {
            throw new InvalidAttributeDataStructureException('Headers properties not found');
        }
        if (!is_array($tableData['headers']) || count($tableData['headers']) === 0) {
            throw new InvalidAttributeDataStructureException('Headers properties is empty');
        }
        if (!key_exists('rows', $tableData)) {
            throw new InvalidAttributeDataStructureException('Rows properties not found');
        }
        if (!is_array($tableData['rows']) || count($tableData['rows']) === 0) {
            throw new InvalidAttributeDataStructureException('Rows properties is empty');
        }

        $availableTypeIds = $this->typeRepository->all()->pluck('id')->toArray();

        $totalColumns = count($tableData['headers']);
        array_walk($tableData['rows'], function ($item) use ($totalColumns, $availableTypeIds) {
            if (count($item['columns']) !== $totalColumns) {
                throw new InvalidAttributeDataStructureException('Bad data structure');
            }

            array_walk($item['columns'], function ($item) use ($availableTypeIds) {
                if (!key_exists('typeId', $item) || !in_array($item['typeId'], $availableTypeIds)) {
                    throw new InvalidAttributeTypeException('Unsupported attribute type');
                }
            });
        });

        return true;
    }

    /**
     * @param array $data
     * @return Attribute
     * @throws FailedAttributeCreateException
     */
    private function createAttributeWithTableType(array $data): Attribute
    {
        try {
            $tableData = $data['data'];
            $parentAttribute = $this->repository->create($data);

            $columns = $this->createTableTypeColumns($tableData['headers'], $parentAttribute->id);

            foreach ($tableData['rows'] as $rowKey => $rowValue) {
                $row = $this->repository->createTableTypeRow($parentAttribute->id, $rowValue['name']);

                foreach ($rowValue['columns'] as $columnKey => $columnValue) {
                    $childAttributeData['typeId'] = $columnValue['typeId'];
                    $childAttributeData['name'] = $this->generateNameForCell($rowKey, $columnKey, $parentAttribute->templateId);
                    $childAttributeData['parentAttributeId'] = $parentAttribute->id;
                    $childAttributeData['templateId'] = $parentAttribute->templateId;
                    $childAttributeData['tableTypeRowId'] = $row->id;
                    $childAttributeData['tableTypeColumnId'] = $columns[$columnKey]->id;
                    $childAttributeData['isLocked'] = !empty($columnValue['isLocked']) ? $columnValue['isLocked'] : false;

                    $this->repository->create($childAttributeData);
                }
            }
        } catch (Exception $e) {
            throw new FailedAttributeCreateException('The process of creating the attribute failed with an error', $e->getCode(), $e);
        }

        return $parentAttribute;
    }

    /**
     * @param integer $row
     * @param integer $column
     * @param integer $templateId
     * @return string
     */
    private function generateNameForCell(int $row, int $column, int $templateId): string
    {
        return 'row_' . $row . '*' . 'column_' . $column . '*' . 'template_' . $templateId;
    }

    /**
     * @param array   $headers
     * @param integer $parentAttributeId
     * @return array
     */
    private function createTableTypeColumns(array $headers, int $parentAttributeId): array
    {
        return array_map(function ($item) use ($parentAttributeId) {
            return $this->repository->createTableTypeColumn($parentAttributeId, $item['name']);
        }, $headers);
    }

    /**
     * @param integer $id
     * @return integer
     * @throws FailedAttributeDeleteException
     */
    public function delete(int $id): ?int
    {
        try {
            $attribute = $this->repository->find($id);
        } catch (ModelNotFoundException $e){
            return null;
        }

        if ($attribute->parent_attribute_id) {
            throw new FailedAttributeDeleteException('Removing an attribute that has a parent attribute is not possible');
        } else {
            return $this->repository->delete($id);
        }
    }

    /**
     * @param array   $data
     * @param integer $id
     * @return Attribute
     * @throws FailedAttributeCreateException
     * @throws InvalidAttributeDataStructureException
     * @throws InvalidAttributeTypeException
     */
    private function updateComplexAttribute(array $data, int $id): Attribute
    {
        $attribute = $this->repository->find($id);

        if ($attribute->type->machineName == TypeService::TYPE_TABLE) {
            $this->validateTable($data);
            return $this->updateAttributeWithTableType($data, $id);
        } else {
            throw new InvalidAttributeTypeException('Unsupported attribute type');
        }
    }

    /**
     * @param array   $data
     * @param integer $id
     * @return Attribute
     * @throws FailedAttributeCreateException
     */
    private function updateAttributeWithTableType(array $data, int $id): Attribute
    {
        try {
            $tableData = $data['data'];

            $this->repository->update($data, $id);
            $parentAttribute = $this->repository->find($id);

            $childAttributesIds = [];

            $columns = $this->updateTableTypeColumns($tableData['headers'], $parentAttribute->id);

            $this->repository->deleteTableTypeRowsByAttributeId($parentAttribute->id);

            foreach ($tableData['rows'] as $rowKey => $rowValue) {
                $row = $this->repository->createTableTypeRow($parentAttribute->id, $rowValue['name']);

                foreach ($rowValue['columns'] as $columnKey => $columnValue) {
                    $childAttributeData['typeId'] = $columnValue['typeId'];
                    $childAttributeData['name'] = $this->generateNameForCell($rowKey, $columnKey, $parentAttribute->templateId);
                    $childAttributeData['parentAttributeId'] = $parentAttribute->id;
                    $childAttributeData['templateId'] = $parentAttribute->templateId;
                    $childAttributeData['tableTypeRowId'] = $row->id;
                    $childAttributeData['tableTypeColumnId'] = $columns[$columnKey]->id;
                    $childAttributeData['isLocked'] = !empty($columnValue['isLocked']) ? $columnValue['isLocked'] : false;

                    if (!empty($columnValue['id']) && $this->repository->isExistChildAttribute($columnValue['id'], $parentAttribute->id)) {
                        $createdAttribute = $this->repository->update($childAttributeData, $columnValue['id']);
                    } else {
                        $createdAttribute = $this->repository->create($childAttributeData);
                    }
                    array_push($childAttributesIds, $createdAttribute->id);
                }
            }

            $this->repository->deleteAttributesByIds(array_diff($parentAttribute->childAttributes->pluck('id')->toArray(), $childAttributesIds));
        } catch (Exception $e) {
            throw new FailedAttributeCreateException('The process of updating the attribute failed with an error', $e->getCode(), $e);
        }

        return $parentAttribute;
    }

    /**
     * @param array   $headers
     * @param integer $parentAttributeId
     * @return array
     */
    private function updateTableTypeColumns(array $headers, int $parentAttributeId)
    {
        $this->repository->deleteTableTypeColumnsByAttributeId($parentAttributeId);

        return array_map(function ($item) use ($parentAttributeId) {
            return $this->repository->createTableTypeColumn($parentAttributeId, $item['name']);
        }, $headers);
    }
}
