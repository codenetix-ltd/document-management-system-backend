<?php
namespace App\Traits\Entity;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
trait HasName
{
    private $name;

    public function getName() : string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}