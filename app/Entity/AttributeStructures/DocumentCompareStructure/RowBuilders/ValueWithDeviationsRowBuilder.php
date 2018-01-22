<?php
namespace App\Entity\AttributeStructures\DocumentCompareStructure\RowBuilders;

use App\Entity\AttributeStructures\DocumentCompareStructure\AttributesRow;
use Illuminate\Contracts\Container\Container;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class ValueWithDeviationsRowBuilder implements IRowBuilder
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function build($attribute, $documents)
    {
        $id = $attribute->getId();
        $row = new AttributesRow($attribute->getName());
        $documents->each(function ($item) use ($id, $row) {
            $foundAttribute = $item->getAttributes()->findAttributeById($id);
            if ($foundAttribute) {
                $row->addAttribute($foundAttribute);
            }
        });
        return $row;
    }
}