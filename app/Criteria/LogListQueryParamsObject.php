<?php

namespace App\Criteria;


/**
 * Created by Andrew Sparrow <andrew.sprw@gmail.com>
 */
class LogListQueryParamsObject extends QueryParamsObject
{
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
    public function getAllowedFieldsToSort(): array
    {
        return ['body', 'user.full_name'];
    }
}