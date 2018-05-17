<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Attribute.
 */
class Attribute extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'type_id'];

    private $data;

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

    public function setData(array $data = null): self
    {
        $this->data = $data;

        return $this;
    }

    public function getData(): ?array
    {
        return $this->data;
    }
}
