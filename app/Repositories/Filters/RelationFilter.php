<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;

class RelationFilter implements FilterInterface
{
    /**
     * @var FilterInterface
     */
    private $relationFilter;

    /**
     * @var string
     */
    private $relationName;

    /**
     * RelationFilter constructor.
     * @param FilterInterface $relationFilter
     * @param string          $relationName
     */
    public function __construct(FilterInterface $relationFilter, string $relationName)
    {
        $this->relationFilter = $relationFilter;
        $this->relationName = $relationName;
    }

    /**
     * @param Builder $builder
     * @return void
     */
    public function apply(Builder $builder)
    {
        $builder->whereHas($this->relationName, function (Builder $query) {
            $this->relationFilter->apply($query);
        });
    }
}
