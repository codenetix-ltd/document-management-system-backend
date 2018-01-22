<?php

namespace App\Contracts\Commands\Paginators;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IUserPaginatorCommand
{
    /**
     * @return LengthAwarePaginator
     */
    public function getResult();
}