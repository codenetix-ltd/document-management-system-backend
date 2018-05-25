<?php

namespace App\Repositories;

use App\Entities\AttributeValue;

/**
 * Class DocumentRepositoryEloquent.
 */
class AttributeValueRepositoryEloquent extends BaseRepository implements AttributeValueRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AttributeValue::class;
    }
}
