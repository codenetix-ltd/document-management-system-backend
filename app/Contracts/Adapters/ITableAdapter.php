<?php

namespace App\Contracts\Adapters;

use App\Attribute;
use App\Entity\Attributes\ATable;
use Illuminate\Database\Eloquent\Collection;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
interface ITableAdapter
{
    public function transform(Attribute $attribute, Collection $childAttributes, Collection $columns, Collection $rows): ATable;
}