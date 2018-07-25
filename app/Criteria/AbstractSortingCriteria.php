<?php

namespace App\Criteria;

use App\Entities\BaseEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
abstract class AbstractSortingCriteria implements CriteriaInterface
{
    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $orderBy
     * @param $sortedBy
     * @param BaseEntity|Builder $model
     *
     * @return mixed
     */
    abstract function applySort($orderBy, $sortedBy, $model);

     /**
      * Apply criteria in query repository
      *
      * @param                     $model
      * @param RepositoryInterface $repository
      *
      * @return mixed
      */
     public function apply($model, RepositoryInterface $repository)
     {
         $orderBy = $this->request->get(config('repository.criteria.params.orderBy', 'orderBy'), null);

         $sortedBy = $this->request->get(config('repository.criteria.params.sortedBy', 'sortedBy'), 'asc');

         return $this->applySort($orderBy, $sortedBy, $model);
     }
 }
