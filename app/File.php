<?php

namespace App;

use App\Contracts\Models\IFile;
use Illuminate\Database\Eloquent\Model;

class File extends Model implements IFile
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path', 'original_name'
    ];

}
