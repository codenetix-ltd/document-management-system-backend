<?php

namespace App\QueryParams;

/**
 * Created by Andrew Sparrow <andrew.sprw@gmail.com>
 */
class EmptyQueryParamsObject extends QueryParamsObject
{
    /**
     * @var array
     */
    protected $allowedFieldsToFilter = [];

    /**
     * @var array
     */
    protected $allowedIncludes = [];

    /**
     * @var array
     */
    protected $allowedFieldsToSort = [];

    /**
     * EmptyQueryParamsObject constructor.
     * @param array $filterData
     * @param array $sortData
     * @param array $includeData
     * @param array $paginationData
     */
    public function __construct(array $filterData, array $sortData, array $includeData, array $paginationData)
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
     * @param array $allowedFieldsToFilter
     * @return EmptyQueryParamsObject
     */
    public function setAllowedFieldsToFilter(array $allowedFieldsToFilter): EmptyQueryParamsObject
    {
        $this->allowedFieldsToFilter = $allowedFieldsToFilter;

        return $this;
    }

    /**
     * @param array $allowedIncludes
     * @return EmptyQueryParamsObject
     */
    public function setAllowedIncludes(array $allowedIncludes): EmptyQueryParamsObject
    {
        $this->allowedIncludes = $allowedIncludes;

        return $this;
    }

    /**
     * @param array $allowedFieldsToSort
     * @return EmptyQueryParamsObject
     */
    public function setAllowedFieldsToSort(array $allowedFieldsToSort): EmptyQueryParamsObject
    {
        $this->allowedFieldsToSort = $allowedFieldsToSort;

        return $this;
    }
}
