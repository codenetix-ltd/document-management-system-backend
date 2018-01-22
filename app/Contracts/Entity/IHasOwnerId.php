<?php

namespace App\Contracts\Entity;


interface IHasOwnerId
{
    public function getOwnerId() : int;
    public function setOwnerId(int $user) : void;
}
