<?php

namespace App\Contracts\Commands\Paginators;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IRolePaginatorCommand
{
    /**
     * @return LengthAwarePaginator
     */
    public function getResult();
}