<?php
namespace App\Contracts\Entity;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
interface IHasName
{
    public function getName() : string;
    public function setName(string $name);
}