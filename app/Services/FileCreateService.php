<?php

namespace App\Services;

use App\Contracts\Models\IFile;
use App\Contracts\Repositories\IFileRepository;
use App\Contracts\Services\IFileCreateService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class FileCreateService implements IFileCreateService
{
    private $repository;

    public function __construct(IFileRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createImage(UploadedFile $file, $path = ''): IFile
    {
        $storagePath = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();
        $fileName = str_random(16) . '.' . $file->extension();

        $this->createDirectory($path);

        $fullPath = $storagePath . $path . $fileName;

        $image = Image::make($file)->fit(300)->save($fullPath);

        $file = $this->repository->create(['path' => $path . $image->basename, 'original_name' => $image->basename]);

        return $file;
    }

    public function createDirectory($path): bool
    {
        return File::isDirectory($path) ? true : Storage::disk('public')->makeDirectory($path);
    }
}