<?php
namespace App\Traits\Entity;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
trait HasTypeName
{
    private $typeName;

    public function getTypeName() : string
    {
        return $this->typeName;
    }

    public function setTypeName(string $typeName): void
    {
        $this->typeName = $typeName;
    }
}