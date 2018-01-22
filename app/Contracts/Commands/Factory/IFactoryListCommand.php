<?php

namespace App\Contracts\Commands\Factory;

use App\Contracts\Models\IFactory;
use Illuminate\Database\Eloquent\Collection;

interface IFactoryListCommand
{
    /**
     * @return Collection|IFactory
     */
    public function getResult();
}