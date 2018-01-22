<?php

namespace App;

use App\Contracts\Models\IDocumentVersion;
use Illuminate\Database\Eloquent\Model;

class DocumentVersion extends Model implements IDocumentVersion
{
    protected $casts = [
        'is_actual' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_actual', 'document_id', 'version_name', 'comment', 'file_id',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class)->withTrashed();
    }

    public function files()
    {
        return $this->belongsToMany(File::class, 'document_version_files');
    }

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class, 'document_version_id', 'id');
    }
}
