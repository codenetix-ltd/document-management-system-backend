<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;

class OneOfFilter implements FilterInterface
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
     * @var string
     */
    private $delimiter;

    /**
     * OneOfFilter constructor.
     * @param string $attribute
     * @param string $value
     * @param string $delimiter
     */
    public function __construct(string $attribute, string $value, string $delimiter = ',')
    {
        $this->attribute = $attribute;
        $this->value = $value;
        $this->delimiter = $delimiter;
    }

    /**
     * @param Builder $builder
     * @return void
     */
    public function apply(Builder $builder)
    {
        $builder->whereIn($this->attribute, explode($this->delimiter, $this->value));
    }
}
