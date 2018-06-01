<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    /**
     * @param Builder $builder
     * @return void
     */
    public function apply(Builder $builder);
}
