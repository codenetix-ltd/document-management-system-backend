<?php

namespace App\Entity;
use App\Contracts\Entity\IHasAttributes;
use App\DocumentVersion;
use App\Entity\Attributes\AttributesCollection;
use App\Entity\Parameters\AParametersCollection;
use App\Entity\Parameters\ParametersCollection;
use App\Factory;
use App\Template;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;


/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class Document implements IHasAttributes
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \App\Document
     */
    private $baseModel;

    /**
     * @var Carbon
     */
    private $updatedAt;

    /**
     * @var Carbon
     */
    private $createdAt;

    /**
     * @var AttributesCollection
     */
    private $attributes;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Template
     */
    private $templateModel;

    /**
     * @var Collection
     */
    private $factoryModels;

    /**
     * @var User
     */
    private $userModel;

    /**
     * @var DocumentVersion
     */
    private $documentVersionModel;

    /**
     * @var bool
     */
    private $isTrashed;
    /**
     * @var Collection
     */
    private $documentVersionModels;

    /**
     * @var Collection
     */
    private $labelModels;

    /**
     * @var Collection
     */
    private $parameters;

    /**
     * Document constructor.
     */
    public function __construct()
    {
        $this->attributes = new AttributesCollection();
        $this->factoryModels = new Collection();
        $this->documentVersionModels  = new Collection();
        $this->labelModels = new Collection();
        $this->parameters = new ParametersCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return \App\Document
     */
    public function getBaseModel(): \App\Document
    {
        return $this->baseModel;
    }

    /**
     * @param \App\Document $baseModel
     */
    public function setBaseModel(\App\Document $baseModel)
    {
        $this->baseModel = $baseModel;
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
    public function setAttributes(AttributesCollection $attributes) : void
    {
        $this->attributes = $attributes;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return Template
     */
    public function getTemplateModel(): Template
    {
        return $this->templateModel;
    }

    /**
     * @param Template $templateModel
     */
    public function setTemplateModel(Template $templateModel)
    {
        $this->templateModel = $templateModel;
    }

    /**
     * @return Collection
     */
    public function getFactoryModels(): Collection
    {
        return $this->factoryModels;
    }

    /**
     * @param Collection $factoryModels
     */
    public function setFactoryModels(Collection $factoryModels)
    {
        $this->factoryModels = $factoryModels;
    }

    /**
     * @return User
     */
    public function getUserModel(): User
    {
        return $this->userModel;
    }

    /**
     * @param User $userModel
     */
    public function setUserModel(User $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * @return DocumentVersion
     */
    public function getDocumentVersionModel(): DocumentVersion
    {
        return $this->documentVersionModel;
    }

    /**
     * @param DocumentVersion $documentVersionModel
     */
    public function setDocumentVersionModel(DocumentVersion $documentVersionModel)
    {
        $this->documentVersionModel = $documentVersionModel;
    }

    /**
     * @return boolean
     */
    public function isTrashed(): bool
    {
        return $this->isTrashed;
    }

    /**
     * @param boolean $isTrashed
     */
    public function setIsTrashed(bool $isTrashed)
    {
        $this->isTrashed = $isTrashed;
    }

    /**
     * @return Collection
     */
    public function getDocumentVersionModels(): Collection
    {
        return $this->documentVersionModels;
    }

    /**
     * @param Collection $documentVersionModels
     */
    public function setDocumentVersionModels(Collection $documentVersionModels)
    {
        $this->documentVersionModels = $documentVersionModels;
    }

    /**
     * @return Collection
     */
    public function getLabelModels(): Collection
    {
        return $this->labelModels;
    }

    /**
     * @param Collection $labelModels
     */
    public function setLabelModels(Collection $labelModels)
    {
        $this->labelModels = $labelModels;
    }

    /**
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updatedAt;
    }

    /**
     * @param Carbon $updatedAt
     */
    public function setUpdatedAt(Carbon $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    /**
     * @param Carbon $createdAt
     */
    public function setCreatedAt(Carbon $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return AParametersCollection
     */
    public function getParameters(): AParametersCollection
    {
        return $this->parameters;
    }

    /**
     * @param AParametersCollection $parameters
     */
    public function setParameters(AParametersCollection $parameters) : void
    {
        $this->parameters = $parameters;
    }
}