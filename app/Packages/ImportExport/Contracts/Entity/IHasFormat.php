<?php

namespace App\Packages\ImportExport\Contracts\Entity;

interface IHasFormat
{
    public function getFormat() : string;
    public function setFormat(string $format) : void;
}