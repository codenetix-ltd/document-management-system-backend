<?php

namespace App\Contracts\Services\File;

use App\File;
use Illuminate\Http\UploadedFile;

interface IFileManager
{
    public function createImageFile(UploadedFile $file, $path = '') : File;
}