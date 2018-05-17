<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    protected $fillable = [
        'attribute_id', 'document_version_id', 'version_name', 'version_name', 'value',
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
