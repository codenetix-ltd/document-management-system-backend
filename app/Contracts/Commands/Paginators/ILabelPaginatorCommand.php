<?php

namespace App\Contracts\Commands\Paginators;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ILabelPaginatorCommand
{
    /**
     * @return LengthAwarePaginator
     */
    public function getResult();
}