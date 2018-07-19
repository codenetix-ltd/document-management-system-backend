<?php

namespace App\Criteria;

use App\Repositories\Filters\DateFilter;
use App\Repositories\Filters\EqualsFilter;
use App\Repositories\Filters\LikeFilter;
use App\Repositories\Filters\OneOfFilter;
use App\Repositories\Filters\RelationFilter;
use App\Repositories\Filters\StartsWithFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class LogFilterCriteria implements CriteriaInterface
{
    /**
     * @var Request
     */
    private $request;

    /**
     * DocumentFilterCriteria constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply criteria in query repository
     *
     * @param Model               $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $filters = $this->request->query->get('filters');

        if (!$filters) {
            return $model;
        }

        $builder = $model->newQuery();

        if (isset($filters['id'])) {
            (new EqualsFilter('id', $filters['id']))->apply($builder);
        }

        if (isset($filters['user'])) {
            $startsWithFilter = (new StartsWithFilter('name', $filters['user']));
            (new RelationFilter($startsWithFilter, 'user'))->apply($builder);
        }

        if (isset($filters['action'])) {
            (new LikeFilter('body', $filters['action']))->apply($builder);
        }

        if (isset($filters['type'])) {
            (new OneOfFilter('reference_type', $filters['type']))->apply($builder);
        }

        $this->applyDateFilters($builder, 'createdAt', $filters, 'created_at');

        return $builder;
    }

    private function applyDateFilters(Builder $builder, $field, $filters, $dbAttribute)
    {
        if (isset($filters[$field.'.from'])) {
            $carbon = Carbon::parse(str_replace('"', '', $filters[$field.'.from']))->startOfDay();
            (new DateFilter($dbAttribute, $carbon, DateFilter::FROM))->apply($builder);
        }

        if (isset($filters[$field.'.to'])) {
            $carbon = Carbon::parse(str_replace('"', '', $filters[$field.'.to']))->endOfDay();
            (new DateFilter($dbAttribute, $carbon, DateFilter::TO))->apply($builder);
        }
    }
}
