<?php
namespace App\Contracts\Entity;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
interface IHasId
{
    public function getId() : int;

    public function setId(int $id);
}