<?php
namespace App\Entity\AttributeStructures\DocumentCompareStructure\RowBuilders;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
interface IRowBuilder
{
    public function build($attribute, $documents);
}