<?php

namespace App\Entities;

use Carbon\Carbon;

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
 * @property int $tableTypeRowId
 * @property int $tableTypeColumnId
 *
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 */
class Attribute extends BaseModel
{
    public $enforceCamelCase = false;
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

    public function childAttributes()
    {
        return $this->hasMany(Attribute::class, 'parent_attribute_id', 'id');
    }
}
