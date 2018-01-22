<?php

namespace App\Entity\Attributes;

use App\Entity\Attributes\AttributeBuilders\AttributeBuilder;
use App\Entity\Attributes\AttributeBuilders\IAttributeBuilder;
use App\Entity\Attributes\AttributeBuilders\TableAttributeBuilder;
use Illuminate\Contracts\Container\Container;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class AttributeFactoryMethod
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function make($attribute) : AAttribute {
        switch ($attribute->type->machine_name){
            case 'table':
                return (new TableAttributeBuilder($this->container))->build($attribute);
            case 'boolean':
                return new BooleanAttribute($attribute->id, $attribute->name, $attribute->type_id, $attribute->type->machine_name, $attribute->is_locked);
            case 'numeric':
                return new NumericAttribute($attribute->id, $attribute->name, $attribute->type_id, $attribute->type->machine_name, $attribute->is_locked);
            case 'string':
                return new StringAttribute($attribute->id, $attribute->name, $attribute->type_id, $attribute->type->machine_name, $attribute->is_locked);
            case 'value_with_deviations':
                return new ValueWithDeviationsAttribute($attribute->id, $attribute->name, $attribute->type_id, $attribute->type->machine_name, $attribute->is_locked);
            default:
                throw new \RuntimeException("Wrong attribute type");
        }
    }
}