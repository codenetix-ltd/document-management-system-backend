<?php

namespace App\Packages\ImportExport\Contracts\Services;

interface IDocumentExportService
{
    public function getDocumentId() : int;
    public function setDocumentId(int $documentId) : void;
}