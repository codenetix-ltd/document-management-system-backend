<?php

namespace App\Contracts\Commands\Paginators;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ITemplatePaginatorCommand
{
    /**
     * @return LengthAwarePaginator
     */
    public function getResult();
}