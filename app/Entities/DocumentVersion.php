<?php

namespace App\Entities;

use App\File;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class DocumentVersion.
 *
 * @property string $name
 * @property string $versionName
 * @property string $comment
 * @property int $templateId
 * @property int $ownerId
 *
 * @property Document $document
 * @property Template $template
 * @property Collection|File[] $files
 * @property Collection|AttributeValue[] $attributeValues
 * @property Collection|Label[] $labels
 *
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 */
class DocumentVersion extends BaseEntity implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_actual', 'template_id', 'document_id', 'version_name', 'name', 'comment'
    ];

    public function document()
    {
        return $this->belongsTo(Document::class)->withTrashed();
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function files()
    {
        return $this->belongsToMany(File::class, 'document_version_files');
    }

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class, 'document_version_id', 'id');
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class, 'document_version_tag');
    }

}
