<?php

namespace App\Entities;

use Carbon\Carbon;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Attribute.
 *
 * @property Type $type
 *
 * @property string $name
 * @property bool $isLocked
 * @property int $order
 * @property int $templateId
 * @property int $typeId
 *
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 */
class Attribute extends BaseEntity implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'typeId', 'templateId', 'order', 'tableTypeRowId', 'tableTypeColumnId', 'parentAttributeId', 'isLocked'];

    protected $casts = [
        'is_locked' => 'boolean'
    ];

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
