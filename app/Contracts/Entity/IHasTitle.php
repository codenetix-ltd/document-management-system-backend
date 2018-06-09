<?php

namespace App\Contracts\Entity;

interface IHasTitle
{
    /**
     * @return string
     */
    public function getTitle(): string;
}
