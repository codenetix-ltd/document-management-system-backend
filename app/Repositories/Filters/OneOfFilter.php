<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class OneOfFilter implements FilterInterface
{
    private $attribute;
    private $value;
    private $delimiter;

    public function __construct($attribute, $value, $delimiter = ',')
    {
        $this->attribute = $attribute;
        $this->value = $value;
        $this->delimiter = $delimiter;
    }

    public function apply(Builder $builder)
    {
        $builder->whereIn($this->attribute, explode($this->delimiter, $this->value));
    }
}
