<?php

namespace App\Contracts\Commands\Document;

interface IDocumentsDeleteCommand
{
    /**
     * @return int
     */
    public function getResult();
}