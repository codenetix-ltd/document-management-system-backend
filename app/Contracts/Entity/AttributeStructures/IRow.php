<?php
namespace App\Contracts\Entity\AttributeStructures;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
interface IRow
{
    public function add(IRowItem $item);
}