<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;

class DateFilter implements FilterInterface
{
    const FROM = '>=';
    const TO = '<=';

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
    private $operator;

    /**
     * DateFilter constructor.
     * @param string $attribute
     * @param string $value
     * @param string $operator
     */
    public function __construct(string $attribute, string $value, string $operator = self::FROM)
    {
        $this->attribute = $attribute;
        $this->value = $value;
        $this->operator = $operator;
    }

    /**
     * @param Builder $builder
     * @return void
     */
    public function apply(Builder $builder)
    {
        $builder->whereDate($this->attribute, $this->operator, $this->value);
    }
}
