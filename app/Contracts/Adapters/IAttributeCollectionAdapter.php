<?php

namespace App\Contracts\Adapters;

use Illuminate\Database\Eloquent\Collection;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
interface IAttributeCollectionAdapter
{
    public function transform(Collection $collection);
}