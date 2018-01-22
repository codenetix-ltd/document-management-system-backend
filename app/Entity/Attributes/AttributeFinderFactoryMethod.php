<?php

namespace App\Entity\Attributes;

use App\Contracts\Adapters\ITableAdapter;
use App\Entity\Attributes\AttributeFinders\AttributeFinder;
use App\Entity\Attributes\AttributeFinders\TableAttributeFinder;
use Illuminate\Contracts\Container\Container;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class AttributeFinderFactoryMethod
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function make($attribute){
        switch ($attribute->getTypeName()){
            case 'table':
                return new TableAttributeFinder();
            default:
                return new AttributeFinder();
        }
    }
}