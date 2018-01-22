<?php

namespace App;

use App\Contracts\Entity\IHasId;
use App\Contracts\Entity\IHasOwnerId;
use App\Contracts\Models\IDocument;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model implements IDocument, IHasOwnerId, IHasId
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'template_id', 'owner_id', 'substitute_document_id'
    ];

    public function template()
    {
         return $this->belongsTo(Template::class);
    }

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

    public function factories()
    {
        return $this->belongsToMany(Factory::class, 'document_factories');
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class, 'document_label');
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
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        // TODO: Implement setId() method.
    }
}
