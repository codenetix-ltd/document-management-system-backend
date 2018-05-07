<?php

namespace App;

use App\Contracts\Entity\IHasId;
use App\Contracts\Entity\IHasOwnerId;
use App\Contracts\Models\IDocument;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Class Document
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @package App
 */
class Document extends Model implements IHasOwnerId, IHasId
{
    use SoftDeletes;

    private $actualVersion;

    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_id', 'substitute_document_id'
    ];


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

    public function getViewURL(){
        return route('documents.view', ['id' => $this->id]);
    }

    public function getViewURLLink(){
        return '<a href="'.$this->getViewURL().'" target="blank">'. $this->name . '</a>';
    }

    public function getOwnerId() : int
    {
        return $this->owner_id;
    }

    public function setOwnerId(int $ownerId) : void
    {
        $this->owner_id = $ownerId;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getActualVersion(): ?DocumentVersion
    {
        return $this->actualVersion;
    }

    public function setActualVersion(DocumentVersion $value): self
    {
        $this->actualVersion = $value;

        return $this;
    }

    public function getSubstituteDocumentId(): ?int
    {
        return $this->substitute_document_id;
    }

    public function setSubstituteDocumentId(?int $value): self
    {
        $this->substitute_document_id = $value;

        return $this;
    }

    public function getCreatedAt(): int
    {
        return $this->created_at->timestamp;
    }

    public function getUpdatedAt(): int
    {
        return $this->updated_at->timestamp;
    }
}
