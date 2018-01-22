<?php

namespace App\Packages\ImportExport\Contracts\Entity;

interface IHasParams
{
    public function getParams() : array;
    public function setParams(array $params);
}