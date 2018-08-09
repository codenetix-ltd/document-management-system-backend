<?php

namespace App\Criteria;


/**
 * Created by Andrew Sparrow <andrew.sprw@gmail.com>
 */
class EmptyQueryParamsObject extends QueryParamsObject
{

    protected $allowedFieldsToFilter = [];

    protected $allowedIncludes = [];

    protected $allowedFieldsToSort = [];

    /**
     * EmptyQueryParamsObject constructor.
     * @param $filterData
     * @param $sortData
     * @param $includeData
     * @param $paginationData
     */
    public function __construct($filterData, $sortData, $includeData, $paginationData)
    {
        parent::__construct($filterData, $sortData, $includeData, $paginationData);
    }

    /**
     * @return array
     */
    public function getAllowedFieldsToFilter(): array
    {
        return $this->allowedFieldsToFilter;
    }

    /**
     * @return array
     */
    public function getAllowedIncludes(): array
    {
        return $this->allowedIncludes;
    }

    /**
     * @return array
     */
    public function getAllowedFieldsToSort(): array
    {
        return $this->allowedFieldsToSort;
    }

    /**
     * @param mixed $allowedFieldsToFilter
     * @return EmptyQueryParamsObject
     */
    public function setAllowedFieldsToFilter($allowedFieldsToFilter): EmptyQueryParamsObject
    {
        $this->allowedFieldsToFilter = $allowedFieldsToFilter;

        return $this;
    }

    /**
     * @param mixed $allowedIncludes
     * @return EmptyQueryParamsObject
     */
    public function setAllowedIncludes($allowedIncludes): EmptyQueryParamsObject
    {
        $this->allowedIncludes = $allowedIncludes;

        return $this;
    }

    /**
     * @param mixed $allowedFieldsToSort
     * @return EmptyQueryParamsObject
     */
    public function setAllowedFieldsToSort($allowedFieldsToSort): EmptyQueryParamsObject
    {
        $this->allowedFieldsToSort = $allowedFieldsToSort;

        return $this;
    }
}