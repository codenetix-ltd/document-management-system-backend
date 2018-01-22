<?php

namespace App\Services;

use App\Contracts\Commands\ACommand;
use App\Contracts\Entity\IHasAttributes;
use App\Contracts\Entity\IHasDocument;
use App\Entity\Attributes\AttributesCollection;
use App\Entity\Document;
use Illuminate\Contracts\Container\Container;

abstract class ADocumentEditService extends ACommand implements IHasAttributes, IHasDocument
{

    private $documentId;
    private $attributes;
    private $document;
    /**
     * @var int|null
     */
    private $templateId;

    /**
     * ADocumentEditService constructor.
     * @param Container $container
     * @param int $documentId
     * @param int|null $templateId
     */
    public function __construct(Container $container, int $documentId, int $templateId = null)
    {
        parent::__construct($container);
        $this->documentId = $documentId;
        $this->attributes = new AttributesCollection();
        $this->templateId = $templateId;
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
     * @return int|null
     */
    public function getTemplateId()
    {
        return $this->templateId;
    }

    /**
     * @param int|null $templateId
     */
    public function setTemplateId($templateId)
    {
        $this->templateId = $templateId;
    }

}