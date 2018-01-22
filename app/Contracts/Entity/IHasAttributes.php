<?php
namespace App\Contracts\Entity;

use App\Entity\Attributes\AttributesCollection;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
interface IHasAttributes
{
    public function getAttributes() : AttributesCollection;

    public function setAttributes(AttributesCollection $collection) : void;
}