<?php

namespace App\Contracts\Services\Base;

use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;

interface IListService
{
    public function list(): LengthAwarePaginatorContract;
}