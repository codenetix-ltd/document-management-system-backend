<?php
namespace App\Entity\Attributes\AttributeFinders;

use App\Entity\Attributes\AAttribute;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class AttributeFinder implements IAttributeFinder
{

    public function find(AAttribute $attribute, int $id) : ?AAttribute
    {
        if ($attribute->getId() == $id) {
            return $attribute;
        }

        return null;
    }
}