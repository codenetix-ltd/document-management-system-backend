<?php

namespace App\Criteria;

use App\Repositories\Filters\DateFilter;
use App\Repositories\Filters\EqualsFilter;
use App\Repositories\Filters\NotNullFilter;
use App\Repositories\Filters\NullFilter;
use App\Repositories\Filters\OneOfFilter;
use App\Repositories\Filters\RelationFilter;
use App\Repositories\Filters\StartsWithFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class DocumentFilterCriteria implements CriteriaInterface
{

    /**
     * @var Request
     */
    private $request;

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

        if(!$filters) {
            return $model;
        }

        $builder = $model->newQuery();

        if(isset($filters['id'])) {
            (new EqualsFilter('id', $filters['id']))->apply($builder);
        }

        if(isset($filters['ids'])) {
            (new OneOfFilter('id', $filters['ids']))->apply($builder);
        }

        if(isset($filters['ownerId'])) {
            (new EqualsFilter('owner_id', $filters['ownerId']))->apply($builder);
        }

        if(isset($filters['name'])) {
            $startsWithFilter = (new StartsWithFilter('name', $filters['name']));
            (new RelationFilter($startsWithFilter, 'documentActualVersion'))->apply($builder);
        }

        if(isset($filters['templateIds'])) {
            $inFilter = new OneOfFilter('template_id', $filters['templateIds']);
            (new RelationFilter($inFilter, 'documentActualVersion'))->apply($builder);
        }

        if(isset($filters['labelIds'])) {
            $inFilter = new OneOfFilter('id', $filters['labelIds']);
            $documentVersionFilter = new RelationFilter($inFilter, 'labels');
            (new RelationFilter($documentVersionFilter, 'documentActualVersion'))->apply($builder);
        }

        if(isset($filters['archived'])) {
            if ($filters['archived'] === 1) {
                (new NotNullFilter('substitute_document_id'))->apply($builder);
            } else {
                (new NullFilter('substitute_document_id'))->apply($builder);
            }
        }

        $this->applyDateFilters($builder, 'createdAt', $filters, 'created_at');
        $this->applyDateFilters($builder, 'updatedAt', $filters, 'updated_at');

        return $builder;

    }

    private function applyDateFilters(Builder $builder, $field, $filters, $dbAttribute)
    {
        if(isset($filters[$field.'.from'])) {
            (new DateFilter($dbAttribute, $filters[$field.'.from'], DateFilter::FROM))->apply($builder);
        }

        if(isset($filters[$field.'.to'])) {
            (new DateFilter($dbAttribute, $filters[$field.'.from'], DateFilter::TO))->apply($builder);
        }
    }
}
