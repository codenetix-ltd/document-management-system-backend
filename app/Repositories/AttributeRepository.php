<?php

namespace App\Repositories;

use App\Entities\TableTypeColumn;
use App\Entities\TableTypeRow;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface AttributeRepository.
 */
interface AttributeRepository extends RepositoryInterface
{
    public function getTableRowsByAttributeId(int $id): Collection;
    public function getTableColumnsByAttributeId(int $id): Collection;
    public function getChildAttributes(int $id): Collection;
    public function createTableTypeColumn(int $parentAttributeId, string $name): TableTypeColumn;
    public function createTableTypeRow(int $parentAttributeId, string $name): TableTypeRow;
    public function paginateAttributes(int $templateId): LengthAwarePaginator;
    public function deleteTableTypeColumnsByAttributeId(int $id): int;
    public function deleteTableTypeRowsByAttributeId(int $id): int;
    public function isExistChildAttribute(int $childAttributeId, int $parentAttributeId): bool;
    public function deleteAttributesByIds(array $ids): int;
}
