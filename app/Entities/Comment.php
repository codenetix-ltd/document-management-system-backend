<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Comment.
 *
 * @property int $id
 * @property int $user_id
 * @property int $entity_id
 * @property string $entity_type
 * @property int $parent_id
 * @property string $body
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 */
class Comment extends BaseEntity implements Transformable
{
    use SoftDeletes;
    use TransformableTrait;

    protected $table = 'comments';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id', 'body', 'parent_id', 'commentable_id', 'commentable_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}
