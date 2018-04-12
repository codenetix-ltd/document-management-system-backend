<?php

namespace App\Contracts\Repositories;

use App\Contracts\Models\IAttribute;
use App\Contracts\Models\ITableTypeColumn;
use App\Contracts\Models\ITableTypeRow;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface IAttributeRepository
{
    public function getAttributeValuesByDocumentVersionId($documentVersionId);
    public function create(IAttribute $attribute): IAttribute;
    public function createTableTypeColumn(int $parentAttributeId, string $name): ITableTypeColumn;
    public function createTableTypeRow(int $parentAttributeId, string $name): ITableTypeRow;
    public function findOrFail(int $id): IAttribute;
    public function find(int $id): ?IAttribute;
    public function getTableRowsByAttributeId(int $id): Collection;
    public function getTableColumnsByAttributeId(int $id): Collection;
    public function getChildAttributes(int $id): Collection;
    public function delete(int $id): ?bool;
    public function list(): LengthAwarePaginator;
}