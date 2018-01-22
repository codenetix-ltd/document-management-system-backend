<?php
namespace App\Adapters;

use App\Entity\Attributes\AttributeFactoryMethod;
use App\Entity\Attributes\AttributesCollection;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Collection;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class AttributeCollectionAdapter
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function transform(Collection $attributes)
    {
        $attributeCollection = new AttributesCollection();
        foreach ($attributes as $attribute){
            $attributeCollection->push((new AttributeFactoryMethod($this->container))->make($attribute));
        }
        return $attributeCollection;
    }
}