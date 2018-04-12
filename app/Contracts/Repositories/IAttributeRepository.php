<?php

namespace App\Contracts\Repositories;

use App\Contracts\Models\IAttribute;
use App\Contracts\Models\ITableTypeColumn;
use App\Contracts\Models\ITableTypeRow;

interface IAttributeRepository
{
    public function getAttributeValuesByDocumentVersionId($documentVersionId);
    public function create(IAttribute $attribute): IAttribute;
    public function createTableTypeColumn(int $parentAttributeId, string $name): ITableTypeColumn;
    public function createTableTypeRow(int $parentAttributeId, string $name): ITableTypeRow;
}