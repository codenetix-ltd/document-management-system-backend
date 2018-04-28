<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentVersion extends Model
{
    private $_labelIds = [];
    private $_fileIds = [];
    private $_attributeValues = [];

    protected $casts = [
        'is_actual' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'template_id', 'is_actual', 'document_id', 'version_name', 'comment', 'file_id',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class)->withTrashed();
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function files()
    {
        return $this->belongsToMany(File::class, 'document_version_files');
    }

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class, 'document_version_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'document_version_tag');
    }

    public function isActual(): ?bool
    {
        return $this->is_actual;
    }

    public function setActual(bool $isActual): self
    {
        $this->is_actual = $isActual;

        return $this;
    }

    public function getDocumentId(): ?int
    {
        return $this->document_id;
    }

    public function setDocumentId(?int $documentId): self
    {
        $this->document_id = $documentId;

        return $this;
    }

    public function getVersionName(): string
    {
        return $this->version_name;
    }

    public function setVersionName(string $value): self
    {
        $this->version_name = $value;

        return $this;
    }

    public function getTemplateId(): ?int
    {
        return $this->template_id;
    }

    public function setTemplateId(?int $templateId): self
    {
        $this->template_id = $templateId;

        return $this;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $value): self
    {
        $this->comment = $value;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $value): self
    {
        $this->name = $value;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $value): self
    {
        $this->id = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getLabelIds(): array
    {
        return $this->_labelIds;
    }

    /**
     * @param mixed $labelIds
     * @return self
     */
    public function setLabelIds(array $labelIds): self
    {
        $this->_labelIds = $labelIds;

        return $this;
    }

    /**
     * @return array
     */
    public function getFileIds(): array
    {
        return $this->_fileIds;
    }

    /**
     * @param mixed $fileIds
     * @return self
     */
    public function setFileIds(array $fileIds): self
    {
        $this->_fileIds = $fileIds;

        return $this;
    }

    /**
     * @return AttributeValue[]
     */
    public function getAttributeValues(): array
    {
        return $this->_attributeValues;
    }

    public function setAttributeValues(array $value): self
    {
        $this->_attributeValues = $value;

        return $this;
    }

    public function getCreatedAt(): int
    {
        return $this->created_at->timestamp;
    }

    public function getUpdatedAt(): int
    {
        return $this->updated_at->timestamp;
    }
}
