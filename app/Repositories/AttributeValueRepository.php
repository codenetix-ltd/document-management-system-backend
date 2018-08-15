<?php

namespace App\Repositories;

use App\Entities\AttributeValue;

/**
 * Class DocumentRepositoryEloquent.
 */
class AttributeValueRepository extends BaseRepository
{
    /**
     * @return mixed
     */
    protected function getInstance()
    {
        return new AttributeValue();
    }
}
