<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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
class AttributeValue extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'attributeId', 'documentVersionId', 'value',
    ];
    public $enforceCamelCase = false;
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
