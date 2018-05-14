<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class DateFilter implements FilterInterface
{
    const FROM = '>=';
    const TO = '<=';
    private $attribute;
    private $value;
    /**
     * @var string
     */
    private $operator;

    public function __construct($attribute, $value, $operator = self::FROM)
    {
        $this->attribute = $attribute;
        $this->value = $value;
        $this->operator = $operator;
    }

    public function apply(Builder $builder)
    {
        $builder->whereDate($this->attribute, $this->operator, $this->value);
    }
}
