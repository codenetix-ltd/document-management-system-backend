<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'attribute_id', 'document_version_id', 'version_name', 'version_name', 'value',
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function version()
    {
        return $this->hasOne(File::class);
    }

    public function setDocumentVersionId(int $documentVersionId): self
    {
        $this->document_version_id = $documentVersionId;

        return $this;
    }

    public function getDocumentVersionId(): int
    {
        return $this->document_version_id;
    }

    public function setAttributeId(int $value): self
    {
        $this->attribute_id = $value;

        return $this;
    }

    public function getAttributeId(): int
    {
        return $this->attribute_id;
    }

    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }


}
