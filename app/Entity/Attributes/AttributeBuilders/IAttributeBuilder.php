<?php


namespace App\Entity\Attributes\AttributeBuilders;

use App\Entity\Attributes\AAttribute;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
interface IAttributeBuilder
{
    public function build($attribute) : AAttribute;
}