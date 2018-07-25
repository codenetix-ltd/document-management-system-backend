<?php

namespace App\Repositories;

use App\Entities\TableTypeColumn;
use App\Entities\TableTypeRow;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface AttributeRepository.
 */
interface AttributeRepository extends RepositoryInterface
{
    /**
     * @param integer $id
     * @return Collection
     */
    public function getTableRowsByAttributeId(int $id): Collection;

    /**
     * @param integer $id
     * @return Collection
     */
    public function getTableColumnsByAttributeId(int $id): Collection;

    /**
     * @param integer $id
     * @return Collection
     */
    public function getChildAttributes(int $id): Collection;

    /**
     * @param integer $parentAttributeId
     * @param string  $name
     * @return TableTypeColumn
     */
    public function createTableTypeColumn(int $parentAttributeId, string $name): TableTypeColumn;

    /**
     * @param integer $parentAttributeId
     * @param string  $name
     * @return TableTypeRow
     */
    public function createTableTypeRow(int $parentAttributeId, string $name): TableTypeRow;

    /**
     * @param integer $templateId
     * @return LengthAwarePaginator
     */
    public function paginateAttributes(int $templateId): LengthAwarePaginator;

    /**
     * @param integer $id
     * @return integer
     */
    public function deleteTableTypeColumnsByAttributeId(int $id): int;

    /**
     * @param integer $id
     * @return integer
     */
    public function deleteTableTypeRowsByAttributeId(int $id): int;

    /**
     * @param integer $childAttributeId
     * @param integer $parentAttributeId
     * @return boolean
     */
    public function isExistChildAttribute(int $childAttributeId, int $parentAttributeId): bool;

    /**
     * @param array $ids
     * @return integer
     */
    public function deleteAttributesByIds(array $ids): int;
}
