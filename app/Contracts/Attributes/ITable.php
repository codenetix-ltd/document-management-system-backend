<?php

namespace App\Contracts\Attributes;

use Illuminate\Support\Collection;

interface ITable
{
    public function getRows() : Collection;
    public function getColumns() : Collection;
}