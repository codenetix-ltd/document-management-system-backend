<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class RelationFilter implements FilterInterface
{
    /**
     * @var FilterInterface
     */
    private $relationFilter;
    private $relationName;

    public function __construct(FilterInterface $relationFilter, $relationName)
    {
        $this->relationFilter = $relationFilter;
        $this->relationName = $relationName;
    }

    public function apply(Builder $builder)
    {
        $builder->whereHas($this->relationName, function(Builder $query){
            $this->relationFilter->apply($query);
        });
    }
}
