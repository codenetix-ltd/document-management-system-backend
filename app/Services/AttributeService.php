<?php

namespace App\Services;

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
     * @throws FailedAttributeCreateException
     * @throws InvalidAttributeDataStructureException
     * @throws InvalidAttributeTypeException
     */
    public function create($templateId, array $data)
    {
        $data['templateId'] = $templateId;
        $data['order'] = $this->getDefaultAttributeOrderByTemplateId($templateId);

        if (empty($data['data'])) {
            $attribute = $this->repository->create($data);
        } else {
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
        $type = $this->typeRepository->find($attribute->typeId);
        if ($type->machineName == TypeService::TYPE_TABLE) {
            return $this->buildDataForTable($attribute->id);
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
            $dataRow['name'] = $row->name;
            $dataRow['columns'] = [];
            /** @var TableTypeColumn $column */
            foreach ($columns as $column) {
                /** @var Attribute $childAttribute */
                foreach ($childAttributes as $childAttribute) {
                    if ($childAttribute->tableTypeRowId == $row->id && $childAttribute->tableTypeColumnId == $column->id) {
                        //dd($childAttribute->type->toArray());
                        $dataRow['columns'][] = [
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

        //TODO - create factory for different types
        if ($type->machine_name == TypeService::TYPE_TABLE) {
            $this->validateTable($data);
            return $this->createAttributeWithTableType($data);
        } else {
            throw new InvalidAttributeTypeException('Unsupported attribute type');
        }
    }

    /**
     * @param array $data
     * @return bool
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

            array_walk($item['columns'], function($item) use ($availableTypeIds) {
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
                    $childAttributeData = [];
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

    /**
     * @param int $id
     * @return int|null
     * @throws FailedAttributeDeleteException
     */
    public function delete(int $id)
    {
        $attribute = $this->repository->findWhere([['id', '=', $id]])->first();
        if (is_null($attribute)) {
            return null;
        }

        if ($attribute->parent_attribute_id) {
            throw new FailedAttributeDeleteException('Removing an attribute that has a parent attribute is not possible');
        } else {
            return $this->repository->delete($id);
        }
    }
}