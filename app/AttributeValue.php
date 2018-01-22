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
}
