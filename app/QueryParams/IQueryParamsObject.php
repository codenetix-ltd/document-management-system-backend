<?php

namespace App\QueryParams;

/**
 * Created by Andrew Sparrow <andrew.sprw@gmail.com>
 */
interface IQueryParamsObject
{

    /**
     * @return array
     */
    public function getAllowedFieldsToFilter(): array;

    /**
     * @return array
     */
    public function getAllowedIncludes(): array;

    /**
     * @return array
     */
    public function getAllowedFieldsToSort(): array;

    /**
     * @return array
     */
    public function getFiltersData(): array;

    /**
     * @return array
     */
    public function getSortsData(): array;

    /**
     * @return array
     */
    public function getIncludeData(): array;

    /**
     * @return array
     */
    public function getPaginationData(): array;
}
