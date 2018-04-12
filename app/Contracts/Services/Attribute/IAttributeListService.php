<?php

namespace App\Contracts\Services\Attribute;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IAttributeListService
{
    public function list(): LengthAwarePaginator;
}