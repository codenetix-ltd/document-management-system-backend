<?php

namespace App\Entity\Parameters;

use App\Contracts\Entity\IHasCollectionValue;
use App\Traits\Entity\HasCollectionValue;
use Illuminate\Support\Collection;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class CollectionParameter extends AParameter implements IHasCollectionValue
{
    use HasCollectionValue;

    /**
     * CollectionParameter constructor.
     * @param string $name
     * @param Collection $value
     */
    public function __construct(string $name, Collection $value)
    {
        parent::__construct($name);
        $this->value = $value;
    }

    public function getTypeName()
    {
        return 'collection';
    }
}