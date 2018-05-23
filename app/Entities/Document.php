<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Document.
 *
 * @property int $ownerId
 *
 * @property User $owner
 * @property Document $substituteDocument
 * @property DocumentVersion $documentActualVersion
 * @property Collection|DocumentVersion[] $documentVersions
 * @property Collection|Log[] $logs
 *
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 * @property Carbon $deletedAt
 */
class Document extends BaseEntity implements Transformable
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documentVersions()
    {
        return $this->hasMany(DocumentVersion::class)->orderBy('created_at', 'DESC');
    }

    public function logs()
    {
        return $this->morphMany(Log::class, 'reference');
    }
}
