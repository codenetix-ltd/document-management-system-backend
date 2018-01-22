<?php
namespace App\Entity\AttributeStructures\DocumentCompareStructure\RowBuilders;

use App\Entity\AttributeStructures\DocumentCompareStructure\AttributesRow;
use App\Traits\Entity\HasTypeName;
use Illuminate\Contracts\Container\Container;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class AttributesRowBuilder implements IRowBuilder
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

        $maxValue = -1 * PHP_INT_MAX;
        $minValue = PHP_INT_MAX;

        $documents->each(function ($item) use ($id, $row, &$maxValue, &$minValue) {
            $foundAttribute = $item->getAttributes()->findAttributeById($id);
            if ($foundAttribute) {
                $row->setTypeName($foundAttribute->getTypeName());

                $row->addAttribute($foundAttribute);



                if($foundAttribute->getTypeName() == 'value_with_deviations'){
                    //TODO refactoring
                    $values = [$foundAttribute->getValue()->getLeftDeviation(), $foundAttribute->getValue()->getRightDeviation(), $foundAttribute->getValue()->getValue()];

                    foreach ($values as $value){
                        if(!is_numeric($value)){
                            continue;
                        }

                        if($maxValue < $value){
                            $maxValue = $value;
                        }

                        if($minValue > $value){
                            $minValue = $value;
                        }
                    }
                } else {
                    if($foundAttribute->getTypeName() == 'numeric'){
                        if($maxValue < $foundAttribute->getValue()){
                            $maxValue = $foundAttribute->getValue();
                        }

                        if($minValue > $foundAttribute->getValue()){
                            $minValue = $foundAttribute->getValue();
                        }
                    }
                }
            }
        });

        $row->setMaxValue($maxValue);
        $row->setMinValue($minValue);

        return $row;
    }
}