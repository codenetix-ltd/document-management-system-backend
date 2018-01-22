<?php

namespace App\Packages\ImportExport\Contracts\Entity;

interface IHasFileUrl
{
    public function getFileUrl() : string;
    public function setFileUrl($fileUrl) : void;
}