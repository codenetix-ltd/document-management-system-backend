<?php

namespace App\Repositories;

use App\Entities\TableTypeColumn;
use App\Entities\TableTypeRow;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Entities\Attribute;

/**
 * Class DocumentRepositoryEloquent.
 */
class AttributeRepositoryEloquent extends BaseRepository implements AttributeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Attribute::class;
    }

    public function getTableRowsByAttributeId(int $id): Collection
    {
        return TableTypeRow::where('parent_attribute_id', $id)->get();
    }

    public function getTableColumnsByAttributeId(int $id): Collection
    {
        return TableTypeColumn::where('parent_attribute_id', $id)->get();
    }

    public function getChildAttributes(int $id): Collection
    {
        return Attribute::where('parent_attribute_id', $id)->get();
    }

    public function createTableTypeColumn(int $parentAttributeId, string $name): TableTypeColumn
    {
        $tableTypeColumn = new TableTypeColumn();
        $tableTypeColumn->parent_attribute_id = $parentAttributeId;
        $tableTypeColumn->name = $name;
        $tableTypeColumn->save();

        return $tableTypeColumn;
    }

    public function deleteTableTypeColumnsByAttributeId(int $id): int
    {
        return TableTypeColumn::where('parent_attribute_id', $id)->delete();
    }

    public function deleteTableTypeRowsByAttributeId(int $id): int
    {
        return TableTypeRow::where('parent_attribute_id', $id)->delete();
    }

    public function createTableTypeRow(int $parentAttributeId, string $name): TableTypeRow
    {
        $tableTypeRow = new TableTypeRow();
        $tableTypeRow->parent_attribute_id = $parentAttributeId;
        $tableTypeRow->name = $name;
        $tableTypeRow->save();

        return $tableTypeRow;
    }

    public function paginateAttributes(int $templateId): LengthAwarePaginator
    {
        return Attribute::where('parent_attribute_id', null)->where('template_id', $templateId)->paginate();
    }

    public function isExistChildAttribute(int $childAttributeId, int $parentAttributeId): bool
    {
        return Attribute::where('id', $childAttributeId)->where('parent_attribute_id', $parentAttributeId)->exists();
    }

    public function deleteAttributesByIds(array $ids): int
    {
        return Attribute::whereIn('id', $ids)->delete();
    }
}
