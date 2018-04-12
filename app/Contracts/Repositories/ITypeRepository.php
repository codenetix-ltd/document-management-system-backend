<?php

namespace App\Contracts\Repositories;
use App\Contracts\Models\IType;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;

interface ITypeRepository extends IRepository
{
    public function list(): LengthAwarePaginatorContract;
    public function getTypeById(int $id): IType;
    public function getTypeByMachineName(string $machineName): IType;
    public function getTypeIds(): array;
}