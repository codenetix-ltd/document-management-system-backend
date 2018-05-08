<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class StartsWithFilter implements FilterInterface
{
    private $attribute;
    private $value;

    public function __construct($attribute, $value)
    {
        $this->attribute = $attribute;
        $this->value = $value;
    }

    public function apply(Builder $builder)
    {
        $builder->where($this->attribute, 'LIKE', $this->value.'%');
    }
}
