<?php

namespace App\Entities;

class AttributeValue extends BaseEntity
{
    protected $fillable = [
        'attribute_id', 'document_version_id', 'version_name', 'version_name', 'value',
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
