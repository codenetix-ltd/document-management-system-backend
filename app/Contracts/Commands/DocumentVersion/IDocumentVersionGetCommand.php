<?php

namespace App\Contracts\Commands\DocumentVersion;

use App\Contracts\Models\IDocumentVersion;

interface IDocumentVersionGetCommand
{
    /**
     * @return IDocumentVersion
     */
    public function getResult();
}