<?php
namespace App\Entity\AttributeStructures\DocumentCompareStructure\RowBuilders;

use App\Entity\AttributeStructures\DocumentCompareStructure\TitleRow;
use Illuminate\Contracts\Container\Container;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class TitleRowBuilder implements IRowBuilder
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function build($attribute, $documents)
    {
        $row = new TitleRow($attribute->getName());
        $row->setTypeName('title');
        return $row;
    }
}