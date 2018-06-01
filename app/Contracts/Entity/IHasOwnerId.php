<?php

namespace App\Contracts\Entity;

interface IHasOwnerId
{
    /**
     * @return integer
     */
    public function getOwnerId(): int;

    /**
     * @param integer $id
     * @return void
     */
    public function setOwnerId(int $id): void;
}
