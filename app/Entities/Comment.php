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
 * @property int $commentable_id
 * @property string $commentable_type
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

    /**
     * @var string
     */
    protected $table = 'comments';

    /**
     * @var array
     */
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
