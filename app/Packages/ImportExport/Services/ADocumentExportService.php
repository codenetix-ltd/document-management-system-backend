<?php

namespace App\Packages\ImportExport\Services;

use App\Packages\ImportExport\Contracts\Services\IDocumentExportService;
use Illuminate\Container\Container;

abstract class ADocumentExportService extends AExportService implements IDocumentExportService
{
    private $documentId;

    public function __construct(Container $container, int $documentId, array $params, bool $publish, string $fileName = null, string $format = null)
    {
        parent::__construct($container, $params, $publish, $fileName, $format);

        $this->documentId = $documentId;
    }

    public function getDocumentId(): int
    {
        return $this->documentId;
    }

    public function setDocumentId(int $documentId): void
    {
        $this->documentId = $documentId;
    }
}
