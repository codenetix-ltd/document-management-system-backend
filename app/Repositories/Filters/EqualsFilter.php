<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;

class EqualsFilter implements FilterInterface
{
    /**
     * @var string
     */
    private $attribute;

    /**
     * @var string
     */
    private $value;

    /**
     * EqualsFilter constructor.
     * @param string $attribute
     * @param string $value
     */
    public function __construct(string $attribute, string $value)
    {
        $this->attribute = $attribute;
        $this->value = $value;
    }

    /**
     * @param Builder $builder
     * @return void
     */
    public function apply(Builder $builder)
    {
        $builder->where($this->attribute, '=', $this->value);
    }
}
