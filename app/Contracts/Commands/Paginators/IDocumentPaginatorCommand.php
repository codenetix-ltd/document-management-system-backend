<?php

namespace App\Contracts\Commands\Paginators;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IDocumentPaginatorCommand
{
    /**
     * @return LengthAwarePaginator
     */
    public function getResult();
}