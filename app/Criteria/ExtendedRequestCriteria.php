<?php

namespace App\Criteria;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class ExtendedRequestCriteria extends RequestCriteria
{
    /**
     * @param $search
     * @param $fieldsSearchable
     * @param $searchFields
     * @param $searchJoin
     * @param Builder $model
     *
     * @return Builder
     * @throws \Exception
     */
    protected function applySearch($search, $fieldsSearchable, $searchFields, $searchJoin, $model)
    {
        $searchFields = is_array($searchFields) || is_null($searchFields) ? $searchFields : explode(';', $searchFields);
        $fields = $this->parserFieldsSearch($fieldsSearchable, $searchFields);
        $isFirstField = true;
        $searchData = $this->parserSearchData($search);
        $search = $this->parserSearchValue($search);
        $modelForceAndWhere = strtolower($searchJoin) === 'and';

        return $model->where(function ($query) use ($fields, $search, $searchData, $isFirstField, $modelForceAndWhere) {
            /** @var Builder $query */

            foreach ($fields as $field => $condition) {
                if (is_numeric($field)) {
                    $field = $condition;
                    $condition = "=";
                }

                $value = null;

                $condition = trim(strtolower($condition));

                if (isset($searchData[$field])) {
                    $value = ($condition == "like" || $condition == "ilike") ? "%{$searchData[$field]}%" : $searchData[$field];
                } else {
                    if (!is_null($search)) {
                        $value = ($condition == "like" || $condition == "ilike") ? "%{$search}%" : $search;
                    }
                }

                $relation = null;
                if (stripos($field, '.')) {
                    $explode = explode('.', $field);
                    $field = array_pop($explode);
                    $relation = implode('.', $explode);
                }
                $modelTableName = $query->getModel()->getTable();
                if ($isFirstField || $modelForceAndWhere) {
                    if (!is_null($value)) {
                        if (!is_null($relation)) {
                            $query->whereHas($relation, function ($query) use ($field, $condition, $value) {
                                $query->where($field, $condition, $value);
                            });
                        } else {
                            $query->where($modelTableName.'.'.$field, $condition, $value);
                        }
                        $isFirstField = false;
                    }
                } else {
                    if (!is_null($value)) {
                        if (!is_null($relation)) {
                            $query->orWhereHas($relation, function ($query) use ($field, $condition, $value) {
                                $query->where($field, $condition, $value);
                            });
                        } else {
                            $query->orWhere($modelTableName.'.'.$field, $condition, $value);
                        }
                    }
                }
            }
        });
    }

    /**
     * @param $orderBy
     * @param $sortedBy
     * @param Builder $model
     *
     * @return Builder
     */
    protected function applyOrder($orderBy, $sortedBy, $model)
    {
        $orderBy = snake_case($orderBy);
        $split = explode('|', $orderBy);
        if (count($split) > 1) {
            /*
             * ex.
             * products|description -> join products on current_table.product_id = products.id order by description
             *
             * products:custom_id|products.description -> join products on current_table.custom_id = products.id order
             * by products.description (in case both tables have same column name)
             */
            $table = $model->getModel()->getTable();
            $sortTable = $split[0];
            $sortColumn = $split[1];

            $split = explode(':', $sortTable);
            if (count($split) > 1) {
                $sortTable = $split[0];
                $keyName = $table.'.'.$split[1];
            } else {
                /*
                 * If you do not define which column to use as a joining column on current table, it will
                 * use a singular of a join table appended with _id
                 *
                 * ex.
                 * products -> product_id
                 */
                $prefix = str_singular($sortTable);
                $keyName = $table.'.'.$prefix.'_id';
            }

            return $model
                ->leftJoin($sortTable, $keyName, '=', $sortTable.'.id')
                ->orderBy($sortColumn, $sortedBy)
                ->addSelect($table.'.*');
        } else {
            return $model->orderBy($orderBy, $sortedBy);
        }
    }

    /**
     * Override
     * @see RequestCriteria::apply()
     * For changing orderBy value on snake_case
     *
     * @param \Illuminate\Database\Eloquent\Builder|Model $model
     * @param RepositoryInterface $repository
     *
     * @return \Illuminate\Database\Eloquent\Builder|Model|Builder|mixed
     * @throws \Exception
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $fieldsSearchable = $repository->getFieldsSearchable();
        $search = $this->request->get(config('repository.criteria.params.search', 'search'), null);
        $searchFields = $this->request->get(config('repository.criteria.params.searchFields', 'searchFields'), null);
        $filter = $this->request->get(config('repository.criteria.params.filter', 'filter'), null);
        $orderBy = $this->request->get(config('repository.criteria.params.orderBy', 'orderBy'), null);
        $sortedBy = $this->request->get(config('repository.criteria.params.sortedBy', 'sortedBy'), 'asc');
        $with = $this->request->get(config('repository.criteria.params.with', 'with'), null);
        $searchJoin = $this->request->get(config('repository.criteria.params.searchJoin', 'searchJoin'), null);
        $sortedBy = !empty($sortedBy) ? $sortedBy : 'asc';

        if ($search && is_array($fieldsSearchable) && count($fieldsSearchable)) {
            $model = $this->applySearch($search, $fieldsSearchable, $searchFields, $searchJoin, $model);
        }

        if (isset($orderBy) && !empty($orderBy)) {
            $model = $this->applyOrder($orderBy, $sortedBy, $model);
        }

        if (isset($filter) && !empty($filter)) {
            if (is_string($filter)) {
                $filter = explode(';', $filter);
            }

            $model = $model->select($filter);
        }

        if ($with) {
            $with = explode(';', $with);
            $model = $model->with($with);
        }

        return $model;
    }
}
