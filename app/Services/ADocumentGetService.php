<?php

namespace App\Services;

use App\Contracts\Commands\ACommand;
use App\Contracts\Entity\IHasDocument;
use App\Entity\Document;
use Illuminate\Contracts\Container\Container;

abstract class ADocumentGetService extends ACommand implements IHasDocument
{
    private $documentId;
    private $document;

    /**
     * ADocumentViewService constructor.
     * @param Container $container
     * @param int $documentId
     */
    public function __construct(Container $container, int $documentId)
    {
        parent::__construct($container);
        $this->documentId = $documentId;
    }

    /**
     * @return int
     */
    public function getDocumentId(): int
    {
        return $this->documentId;
    }

    /**
     * @param int $documentId
     */
    public function setDocumentId(int $documentId)
    {
        $this->documentId = $documentId;
    }

    /**
     * @return Document
     */
    public function getDocument(): Document
    {
        return $this->document;
    }

    /**
     * @param Document $document
     */
    public function setDocument(Document $document): void
    {
        $this->document = $document;
    }
}