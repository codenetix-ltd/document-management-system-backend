<?php
namespace App\Entity\Attributes\AttributeFinders;

use App\Entity\Attributes\AAttribute;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class TableAttributeFinder implements IAttributeFinder
{

    public function find(AAttribute $attribute, int $id) : ?AAttribute
    {
        foreach ($attribute->getValue()->getRows() as $row) {
            foreach ($row->getCells() as $attribute){
                if ($attribute->getId() == $id) {
                    return $attribute;
                }
            }
        }

        return null;
    }
}