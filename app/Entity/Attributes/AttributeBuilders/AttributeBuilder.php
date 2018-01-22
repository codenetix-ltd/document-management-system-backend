<?php
namespace App\Entity\Attributes\AttributeBuilders;

use App\Contracts\Attributes\IAttribute;
use App\Entity\Attributes\Attribute;
use Illuminate\Contracts\Container\Container;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class AttributeBuilder implements IAttributeBuilder
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function build($attribute) : IAttribute
    {
        return new Attribute($attribute->id, $attribute->name, $attribute->type_id, $attribute->type->name);
    }
}