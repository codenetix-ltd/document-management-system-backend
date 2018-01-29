<?php

namespace App\Contracts\Services\File;

use App\Contracts\Models\IFile;
use Illuminate\Http\UploadedFile;

interface IFileManager
{
    public function __construct(IFileCreateService $fileCreateService);

    public function createImageFile(UploadedFile $file, $path = '') : IFile;
}