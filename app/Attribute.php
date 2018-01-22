<?php

namespace App;

use App\Contracts\Models\IAttribute;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model implements IAttribute
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'template_id', 'name', 'type_id', 'order', 'table_type_row_id', 'table_type_column_id', 'parent_attribute_id', 'is_locked'
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
