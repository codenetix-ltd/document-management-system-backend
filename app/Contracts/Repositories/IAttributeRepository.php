<?php

namespace App\Contracts\Repositories;

use App\Attribute;
use App\TableTypeColumn;
use App\TableTypeRow;
use Illuminate\Database\Eloquent\Collection;

interface IAttributeRepository
{
    public function getAttributeValuesByDocumentVersionId($documentVersionId);
    public function create(Attribute $attribute): Attribute;
    public function createTableTypeColumn(int $parentAttributeId, string $name): TableTypeColumn;
    public function createTableTypeRow(int $parentAttributeId, string $name): TableTypeRow;
    public function findOrFail(int $id): Attribute;
    public function find(int $id): ?Attribute;
    public function getTableRowsByAttributeId(int $id): Collection;
    public function getTableColumnsByAttributeId(int $id): Collection;
    public function getChildAttributes(int $id): Collection;
    public function delete(int $id): ?bool;
    public function list(int $templateId): Collection;
    public function getDefaultAttributeOrderByTemplateId(int $templateId): int;
}