<?php

namespace App\Services;

use App\Contracts\Builders\IDocumentParameterCollectionBuilder;
use App\Contracts\Commands\ACommand;
use App\Contracts\Entity\IHasAttributes;
use App\Contracts\Entity\IHasDocument;
use App\Entity\Attributes\AttributesCollection;
use App\Entity\Document;
use Illuminate\Contracts\Container\Container;

abstract class ADocumentViewService extends ACommand implements IHasAttributes, IHasDocument
{

    private $documentId;
    private $attributes;
    private $document;
    /**
     * @var int
     */
    protected $documentVersionId;
    /**
     * @var IDocumentParameterCollectionBuilder
     */
    protected $parameterBuilder;

    /**
     * ADocumentViewService constructor.
     * @param Container $container
     * @param int $documentId
     * @param int|null $documentVersionId
     * @param IDocumentParameterCollectionBuilder $parameterBuilder
     */
    public function __construct(Container $container, int $documentId, int $documentVersionId = null, IDocumentParameterCollectionBuilder $parameterBuilder = null)
    {
        parent::__construct($container);
        $this->documentId = $documentId;
        $this->attributes = new AttributesCollection();
        $this->documentVersionId = $documentVersionId;
        $this->parameterBuilder = $parameterBuilder;
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
     * @return AttributesCollection
     */
    public function getAttributes(): AttributesCollection
    {
        return $this->attributes;
    }

    /**
     * @param AttributesCollection $attributes
     */
    public function setAttributes(AttributesCollection $attributes): void
    {
        $this->attributes = $attributes;
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

    /**
     * @return int
     */
    public function getDocumentVersionId(): int
    {
        return $this->documentVersionId;
    }

    /**
     * @param int $documentVersionId
     */
    public function setDocumentVersionId(int $documentVersionId)
    {
        $this->documentVersionId = $documentVersionId;
    }

}