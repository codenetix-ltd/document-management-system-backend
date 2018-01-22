<?php

namespace App\Services;

use App\Contracts\Builders\IDocumentParameterCollectionBuilder;
use App\Contracts\Commands\ACommand;
use App\Contracts\Entity\IHasAttributes;
use App\Contracts\Entity\IHasDocument;
use App\Entity\Attributes\AttributesCollection;
use App\Entity\Document;
use Illuminate\Contracts\Container\Container;

abstract class AAttributesGetService extends ACommand implements IHasAttributes
{

    protected $templateId;
    private $attributes;

    /**
     * @return int
     */
    public function getTemplateId(): int
    {
        return $this->templateId;
    }

    /**
     * @param int $templateId
     */
    public function setTemplateId(int $templateId)
    {
        $this->templateId = $templateId;
    }

    /**
     * @var int
     */
    protected $documentVersionId;

    /**
     * AAttributesGetService constructor.
     * @param Container $container
     * @param int $templateId
     * @param int|null $documentVersionId
     */
    public function __construct(Container $container, int $templateId, int $documentVersionId = null)
    {
        parent::__construct($container);
        $this->templateId = $templateId;
        $this->attributes = new AttributesCollection();
        $this->documentVersionId = $documentVersionId;
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
     * @return int
     */
    public function getDocumentVersionId(): ?int
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