<?php

namespace App\Contracts\Repositories;

use App\Type;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ITypeRepository extends IRepository
{
    public function list(): LengthAwarePaginator;
    public function getTypeById(int $id): Type;
    public function getTypeByMachineName(string $machineName): Type;
    public function getTypeIds(): array;
}