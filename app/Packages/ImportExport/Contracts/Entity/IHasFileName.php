<?php

namespace App\Packages\ImportExport\Contracts\Entity;

interface IHasFileName
{
    public function getFileName() : string;
    public function setFileName($fileName) : void;
}