<?php

namespace App\Packages\ImportExport\Contracts\Entity;

interface IHasPublish
{
    public function setPublish(bool $publish) : void;
    public function isPublish() : bool;
}