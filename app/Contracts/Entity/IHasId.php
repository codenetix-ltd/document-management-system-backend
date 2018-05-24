<?php

namespace App\Contracts\Entity;

interface IHasId
{
    public function getId();
    public function setId($id);
}
