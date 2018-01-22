<?php

namespace App;

use App\Contracts\Models\ITemplate;
use Illuminate\Database\Eloquent\Model;

class Template extends Model implements ITemplate
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function attributes()
    {
        return $this->hasMany(Attribute::class)->orderBy('order', 'ASC')->whereNull('parent_attribute_id');
    }

    public function logs()
    {
        return $this->morphMany(Log::class, 'reference');
    }

    public function getName()
    {
        return $this->name;
    }

    public function getViewURL(){
        return route('templates.edit', ['id' => $this->id]);
    }

    public function getViewURLLink(){
        return '<a href="'.$this->getViewURL().'" target="blank">'. $this->name . '</a>';
    }
}
