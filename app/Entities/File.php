<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class File
 * @package App
 *
 * @property string $name
 * @property string $path
 * @property string $originalName
 *
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 */
class File extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = ['path', 'original_name'];

    public $enforceCamelCase = false;
}
