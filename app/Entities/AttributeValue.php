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
    /**
     * @var array
     */
    protected $fillable = [
        'attributeId', 'documentVersionId', 'value',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
