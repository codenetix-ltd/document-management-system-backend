<?php

namespace App\Repositories;

use App\Contracts\Repositories\ITypeRepository;
use App\Type;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TypeRepository implements ITypeRepository
{
    public function list(): LengthAwarePaginator
    {
        return Type::paginate();
    }

    public function getTypeById(int $id): Type
    {
        return Type::findOrFail($id);
    }

    public function getTypeByMachineName(string $machineName): Type
    {
        return Type::where('machine_name', $machineName)->firstOrFail();
    }

    public function getTypeIds(): array
    {
        return Type::all()->pluck('id')->toArray();
    }
}