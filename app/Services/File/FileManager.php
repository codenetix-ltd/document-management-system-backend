<?php

namespace App\Services\File;

use App\Contracts\Services\File\IFileCreateService;
use App\Contracts\Services\File\IFileManager;
use App\File;
use Illuminate\Http\UploadedFile;

class FileManager implements IFileManager
{
    private $fileCreateService;

    public function __construct(IFileCreateService $fileCreateService)
    {
        $this->fileCreateService = $fileCreateService;
    }

    public function createImageFile(UploadedFile $file, $path = ''): File
    {
        return $this->fileCreateService->createImage($file, $path);
    }
}