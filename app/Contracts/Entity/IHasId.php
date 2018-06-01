<?php

namespace App\Contracts\Entity;

interface IHasId
{
    /**
     * @return integer
     */
    public function getId(): int;

    /**
     * @param integer $id
     * @return void
     */
    public function setId(int $id): void;
}
