<?php

namespace App\Criteria;


/**
 * Created by Andrew Sparrow <andrew.sprw@gmail.com>
 */
class DocumentListQueryParamsObject extends QueryParamsObject
{
    /**
     * @return array
     */
    public function getAllowedFieldsToFilter(): array
    {
        return ['name', 'labelIds'];
    }

    /**
     * @return array
     */
    public function getAllowedFieldsToSort(): array
    {
        return ['actualVersion.name', 'actualVersion.template.name', 'owner.fullName'];
    }
}