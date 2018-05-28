<?php

namespace App\Entities;

use Carbon\Carbon;

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
class File extends BaseEntity
{
    protected $fillable = ['path', 'original_name'];
}
