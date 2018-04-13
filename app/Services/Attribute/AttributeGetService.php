<?php

namespace App\Services\Attribute;

use App\Attribute;
use App\Contracts\Repositories\IAttributeRepository;
use App\Contracts\Repositories\ITypeRepository;
use App\Contracts\Services\Attribute\IAttributeGetService;
use App\Services\Type\TypeService;
use App\TableTypeColumn;
use App\TableTypeRow;

class AttributeGetService implements IAttributeGetService
{
    private $repository;
    private $typeRepository;

    public function __construct(IAttributeRepository $repository, ITypeRepository $typeRepository)
    {
        $this->repository = $repository;
        $this->typeRepository = $typeRepository;
    }

    public function get(int $id): Attribute
    {
        $attribute = $this->repository->findOrFail($id);
        $attribute->setData($this->buildData($attribute));

        return $attribute;
    }

    private function buildData(Attribute $attribute): ?array
    {
        $type = $this->typeRepository->getTypeById($attribute->getTypeId());
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
                            'typeId' => $childAttribute->getId(),
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
}