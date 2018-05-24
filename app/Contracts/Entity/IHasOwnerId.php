<?php

namespace App\Contracts\Entity;

interface IHasOwnerId
{
    public function getOwnerId();
    public function setOwnerId($id);
}
