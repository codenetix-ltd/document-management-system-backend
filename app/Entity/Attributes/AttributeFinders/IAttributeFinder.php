<?php


namespace App\Entity\Attributes\AttributeFinders;
use App\Entity\Attributes\AAttribute;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
interface IAttributeFinder
{
    public function find(AAttribute $attribute, int $id) : ?AAttribute;
}