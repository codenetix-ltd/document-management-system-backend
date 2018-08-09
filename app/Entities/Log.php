<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Log.
 *
 * @property User|Document|Template|Label $reference
 * @property User $user
 *
 * @property int $id
 * @property string $body
 * @property string $referenceType
 * @property int $referenceId
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 */
class Log extends BaseModel implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'body', 'userId', 'referenceId', 'referenceType'
    ];
    public $enforceCamelCase = false;
    public $fieldMap = [
        'link' => false,
    ];

    public function reference()
    {
        return $this->morphTo()->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
