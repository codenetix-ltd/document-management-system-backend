<?php

namespace App\QueryObject;

use App\Criteria\IQueryParamsObject;
use Illuminate\Database\Eloquent\Builder;

abstract class AQueryObject
{
    /**
     * @var Builder
     */
    private $baseQuery;

    public function __construct(Builder $baseQuery)
    {
        $this->baseQuery = $baseQuery;
    }

    protected function getQuery(){
        return $this->baseQuery;
    }

    protected function map(){
        return [];
    }

    private function applyJoins($path, $model)
    {
        array_pop($path);

        $scope = [];
        while ($relationName = array_shift($path)) {
            array_push($scope, $relationName);
            $model = $this->applyJoin($model, implode('.', $scope));
        }

        return $model;
    }

    public function applyQueryParams(IQueryParamsObject $queryParamsObject)
    {
        $model = $this->getQuery()->select($this->getQuery()->getModel()->getTable().'.*');

        foreach ($queryParamsObject->getSortsData() as $field => $direction) {
            $map = $this->map();
            $field = isset($map[$field]) ? $map[$field] : $field;

            $parts = explode('.', $field);

            if (count($parts) > 1) {
                $model = $this->applyJoins($parts, $model);
                $field = implode('.', [$parts[count($parts)-2], $parts[count($parts)-1]]);
            }

            $model = $model->orderBy($field, $direction);
        }

        foreach ($queryParamsObject->getFiltersData() as $field => $value) {
            $map = $this->map();
            $scope = isset($map[$field]) ? $map[$field] : $field;

            $scopeParts = explode('.', $scope);
            if (count($scopeParts) > 1) {
                $model = $this->applyJoins($scopeParts, $model);
                $model = $this->applyWhere($model, implode('.', [$scopeParts[count($scopeParts)-2], $scopeParts[count($scopeParts)-1]]), $value, $scope);
            } else {
                $model = $this->applyWhere($model, $scope, $value, $scope);
            }

        }

        return $model;
    }

    /**
     * @param $model
     * @param $field
     * @param $value
     * @return mixed
     */
    protected function applyWhere($model, $field, $value, $scope) {
        return $model->where($field, 'LIKE', $value . '%');
    }

    /**
     * @param $model
     * @param $scope
     * @return mixed
     */
    protected function applyJoin($model, $scope)
    {
        return $model;
    }
}