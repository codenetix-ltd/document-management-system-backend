<?php

namespace App\Entity\AttributeStructures\DocumentCompareStructure;

use App\Entity\AttributeStructures\DocumentCompareStructure\RowBuilders\AttributesRowBuilder;
use App\Entity\AttributeStructures\DocumentCompareStructure\RowBuilders\TitleRowBuilder;
use Illuminate\Contracts\Container\Container;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class RowBuilderFactoryMethod
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function make($attribute) {
        switch ($attribute->getTypeName()){
            case 'table':
                return new TitleRowBuilder($this->container);
            default:
                return new AttributesRowBuilder($this->container);
        }
    }
}