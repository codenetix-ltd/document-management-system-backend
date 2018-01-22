<?php

namespace App\Entity\AttributeStructures\DocumentCompareStructure;
use App\Traits\Entity\HasTypeName;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class TitleRow
{
    use HasTypeName;

    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName(){
        return $this->name;
    }
}