<?php

namespace App\Builders\AttributeStructureBuilders;

use App\Entity\Attributes\ValueWithDeviationsAttribute;
use App\Entity\AttributeStructures\DocumentCompareStructure;
use App\Entity\AttributeStructures\DocumentCompareStructure\RowBuilderFactoryMethod;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Collection;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class DocumentCompareStructureBuilder
{
    private $container;
    private $documents;
    private $onlyDifferences;

    public function __construct(Container $container, Collection $documents, $onlyDifferences = false)
    {
        $this->container = $container;
        $this->documents = $documents;
        $this->onlyDifferences = $onlyDifferences;
    }

    public function build()
    {
        $compareStructure = new DocumentCompareStructure();
        $documents = $this->documents;
        $container = $this->container;

        $compareStructure->setDocuments($documents);

        $onlyDifferences = $this->onlyDifferences;
        $documents->first()->getAttributes()->each(function ($item) use ($container, $documents, $compareStructure, $onlyDifferences) {
            $factoryMethod = new RowBuilderFactoryMethod($container);
            $row = $factoryMethod->make($item)->build($item, $documents);


            //TODO: refactoring
            if ($this->onlyDifferences && ($row instanceof DocumentCompareStructure\AttributesRow)) {
                for ($i = 0; $i < $row->getAttributes()->count(); $i++) {
                    for ($j = $i + 1; $j < $row->getAttributes()->count(); $j++) {
                        $value = $row->getAttributes()[$i]->getValue();
                        if($value instanceof ValueWithDeviationsAttribute){
                            if (($row->getAttributes()[$i]->getValue()->getValue() != $row->getAttributes()[$j]->getValue()->getValue()) || ($row->getAttributes()[$i]->getValue()->getLeftDeviation() != $row->getAttributes()[$j]->getValue()->getLeftDeviation()) || ($row->getAttributes()[$i]->getValue()->getRightDeviation() != $row->getAttributes()[$j]->getValue()->getRightDeviation())) {
                                $compareStructure->addRow($row);
                                return;
                            }
                        } else {
                            if ($row->getAttributes()[$i]->getValue() != $row->getAttributes()[$j]->getValue()) {
                                $compareStructure->addRow($row);
                                return;
                            }
                        }
                    }
                }
            } else {
                $compareStructure->addRow($row);
            }


        });

        return $compareStructure;
    }

}