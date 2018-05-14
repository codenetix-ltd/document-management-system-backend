<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class NullFilter implements FilterInterface
{
    private $attribute;

    public function __construct($attribute)
    {
        $this->attribute = $attribute;
    }

    public function apply(Builder $builder)
    {
        $builder->whereNull($this->attribute);
    }
}
