<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
interface FilterInterface
{
    public function apply(Builder $builder);
}
