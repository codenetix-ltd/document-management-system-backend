<?php

namespace App\Criteria;


/**
 * Created by Andrew Sparrow <andrew.sprw@gmail.com>
 */
interface IQueryParamsObject
{
    public function getAllowedFieldsToFilter();

    public function getAllowedIncludes();

    public function getAllowedFieldsToSort();

    public function getFiltersData();

    public function getSortsData();

    public function getIncludeData();

    public function getPaginationData();
}