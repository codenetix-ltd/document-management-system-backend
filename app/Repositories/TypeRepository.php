<?php

namespace App\Repositories;

use App\Contracts\Repositories\ITypeRepository;
use App\Type;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;

class TypeRepository implements ITypeRepository
{
    public function list(): LengthAwarePaginatorContract
    {
        return Type::paginate();
    }
}