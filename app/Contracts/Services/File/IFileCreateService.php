<?php

namespace App\Contracts\Services\File;

use App\File;
use Illuminate\Http\UploadedFile;

interface IFileCreateService
{
    public function createImage(UploadedFile $file, $path = '') : File;

    public function createDirectory($path) : bool;
}