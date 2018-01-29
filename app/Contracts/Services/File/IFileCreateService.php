<?php

namespace App\Contracts\Services\File;

use App\Contracts\Models\IFile;
use App\Contracts\Repositories\IFileRepository;
use Illuminate\Http\UploadedFile;

interface IFileCreateService
{
    public function __construct(IFileRepository $repository);

    public function createImage(UploadedFile $file, $path = '') : IFile;

    public function createDirectory($path) : bool;
}