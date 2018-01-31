<?php

namespace App\Contracts\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;

interface IRepository
{
    //TODO - надо ли оно тут?
    public function list(): LengthAwarePaginatorContract;
}