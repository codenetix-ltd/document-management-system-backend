<?php

namespace App\Services;

use App\Contracts\Models\IFile;
use App\Contracts\Services\IFileCreateService;
use App\Contracts\Services\IFileManager;
use Illuminate\Http\UploadedFile;

class FileManager implements IFileManager
{
    private $fileCreateService;

    public function __construct(IFileCreateService $fileCreateService)
    {
        $this->fileCreateService = $fileCreateService;
    }

    public function createImageFile(UploadedFile $file, $path = ''): IFile
    {
        return $this->fileCreateService->createImage($file, $path);
    }
}