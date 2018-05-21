<?php

namespace App\Entities;

use App\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Document.
 */
class Document extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ownerId', 'substituteDocumentId'
    ];

    /**
     * @var array
     */
    protected $dates = ['deletedAt'];

    public function owner()
    {
        return $this->hasOne(User::class, 'id', 'owner_id');
    }

    public function substituteDocument()
    {
        return $this->hasOne(Document::class, 'id', 'substitute_document_id');
    }

    public function documentActualVersion()
    {
        return $this->hasOne(DocumentVersion::class)->whereIsActual(1);
    }

    public function documentVersions()
    {
        return $this->hasMany(DocumentVersion::class)->orderBy('created_at', 'DESC');
    }

    public function logs()
    {
        return $this->morphMany(Log::class, 'reference');
    }
}
