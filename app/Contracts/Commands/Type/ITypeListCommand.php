<?php

namespace App\Contracts\Commands\Type;

use App\Contracts\Models\IType;
use Illuminate\Database\Eloquent\Collection;

interface ITypeListCommand
{
    /**
     * @return Collection|IType
     */
    public function getResult();
}