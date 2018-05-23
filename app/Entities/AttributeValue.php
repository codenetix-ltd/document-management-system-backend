<?php

namespace App\Entities;

use Carbon\Carbon;

/**
 * Class AttributeValue
 * @package App\Entities
 *
 * @property string $value
 * @property Attribute $attribute
 *
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 */
class AttributeValue extends BaseEntity
{
    protected $fillable = [
        'attributeId', 'documentVersionId', 'value',
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
