<?php

namespace App\Services;

use App\Repositories\FileRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Entities\File as FileModel;

class FileCreateService
{
    private $repository;

    public function __construct(FileRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createImage(UploadedFile $file, $path = '')
    {
        $storagePath = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();
        $fileName = str_random(16) . '.' . $file->extension();

        $this->createDirectory($path);

        $fullPath = $storagePath . $path . $fileName;

        $image = Image::make($file)->fit(300)->save($fullPath);

        $file = $this->repository->create(['path' => $path . $image->basename, 'original_name' => $image->basename]);

        return $file;
    }

    public function createFile(UploadedFile $file, $path = '')
    {
        $storagePath = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();
        $fileName = str_random(16) . '.' . $file->extension();

        $this->createDirectory($path);

        $file = $file->move($storagePath . $path, $fileName);

        $file = $this->repository->create(['path' => $path . $file->getBasename(), 'original_name' => $file->getBasename()]);

        return $file;
    }

    public function createDirectory($path): bool
    {
        return File::isDirectory($path) ? true : Storage::disk('public')->makeDirectory($path);
    }
}