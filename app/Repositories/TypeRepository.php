<?php

namespace App\Repositories;

use App\Contracts\Models\IType;
use App\Contracts\Repositories\ITypeRepository;
use App\Type;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;

class TypeRepository implements ITypeRepository
{
    public function list(): LengthAwarePaginatorContract
    {
        return Type::paginate();
    }

    public function getTypeById(int $id): IType
    {
        return Type::findOrFail($id);
    }

    public function getTypeByMachineName(string $machineName): IType
    {
        return Type::where('machine_name', $machineName)->firstOrFail();
    }

    public function getTypeIds(): array
    {
        return Type::all()->pluck('id')->toArray();
    }
}