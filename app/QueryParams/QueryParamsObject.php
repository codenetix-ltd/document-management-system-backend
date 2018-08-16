<?php

namespace App\QueryParams;

use Symfony\Component\HttpFoundation\Request;

/**
 * Created by Andrew Sparrow <andrew.sprw@gmail.com>
 */
abstract class QueryParamsObject implements IQueryParamsObject
{

    /**
     * @var array
     */
    protected $filterData;

    /**
     * @var array
     */
    protected $sortData;

    /**
     * @var array
     */
    protected $includeData;

    /**
     * @var array
     */
    protected $paginationData;

    /**
     * QueryParamsObject constructor.
     * @param array $filterData
     * @param array $sortData
     * @param array $includeData
     * @param array $paginationData
     */
    public function __construct(array $filterData, array $sortData, array $includeData, array $paginationData)
    {
        $this->filterData = $filterData;
        $this->sortData = $sortData;
        $this->includeData = $includeData;
        $this->paginationData = $paginationData;
    }

    /**
     * @param Request $request
     * @return QueryParamsObject
     */
    public static function makeFromRequest(Request $request): self
    {
        $rawFilterData = $request->query('filter', []);

        $filterData = [];
        foreach ($rawFilterData as $filterField => $fieldValue) {
            $parts = explode(',', $fieldValue);
            if (count($parts) > 1) {
                $filterData[$filterField] = $parts;
            } else {
                $filterData[$filterField] = $fieldValue;
            }
        }

        $sortData = $request->query('sort', []);

        $rawIncludeData = $request->query('include', '');
        $includeData = explode(',', $rawIncludeData);

        $paginationData = $request->query('pagination', []);

        return new static($filterData, $sortData, $includeData, $paginationData);
    }

    /**
     * @return array
     */
    public function getAllowedFieldsToFilter(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function getAllowedIncludes(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function getAllowedFieldsToSort(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function getFiltersData(): array
    {
        return array_intersect_key($this->filterData, array_flip($this->getAllowedFieldsToFilter()));
    }

    /**
     * @return array
     */
    public function getSortsData(): array
    {
        return array_intersect_key($this->sortData, array_flip($this->getAllowedFieldsToSort()));
    }

    /**
     * @return mixed
     */
    public function getIncludeData(): array
    {
        return array_intersect($this->includeData, $this->getAllowedIncludes());
    }

    /**
     * @return mixed
     */
    public function getPaginationData(): array
    {
        return array_intersect_assoc($this->paginationData, ['page', 'perPage']);
    }
}
