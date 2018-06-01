<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;

class NullFilter implements FilterInterface
{
    /**
     * @var string
     */
    private $attribute;

    /**
     * NullFilter constructor.
     * @param string $attribute
     */
    public function __construct(string $attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * @param Builder $builder
     * @return void
     */
    public function apply(Builder $builder)
    {
        $builder->whereNull($this->attribute);
    }
}
