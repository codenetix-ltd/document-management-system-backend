<?php

namespace App;

use App\Contracts\Models\ILabel;
use Illuminate\Database\Eloquent\Model;

class Label extends Model implements ILabel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public function documents()
    {
        return $this->belongsToMany(Document::class, 'document_label');
    }

    public function logs()
    {
        return $this->morphMany(Log::class, 'reference');
    }

    public function getName()
    {
        return $this->name;
    }
}
