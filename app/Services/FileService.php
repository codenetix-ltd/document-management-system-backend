<?php

namespace App\Services;

use App\Repositories\FileRepository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class FileService
{
    /**
     * @var FileRepository
     */
    private $repository;

    /**
     * FileService constructor.
     * @param FileRepository $repository
     */
    public function __construct(FileRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $disk
     */
    public function cleanDisk(string $disk){
        (new Filesystem)->cleanDirectory(Storage::disk($disk)->getDriver()->getAdapter()->getPathPrefix());
    }

    /**
     * @param string $disk
     * @param string $fromDir
     * @param string $toDir
     */
    public function moveFileInsideDisk(string $disk, string $fromDir, string $toDir){
        Storage::disk($disk)->move($fromDir, $toDir);
    }

    /**
     * @param string $disk
     * @return string
     */
    public function getDiskPath(string $disk): string {
        return Storage::disk($disk)->getDriver()->getAdapter()->getPathPrefix();
    }

    /**
     * Return disk size in kilobytes
     *
     * @param string $disk
     * @return int
     */
    public function getDiskUsageTotal(string $disk): int
    {
        $path = $this->getDiskPath($disk);

        if (!is_dir($path)) {
            return 0;
        }

        $io = popen ( '/usr/bin/du -k ' . $path, 'r' );
        $size = fgets ( $io, 4096);
        $size = substr ( $size, 0, strpos ( $size, "\t" ) );
        pclose ( $io );

        return $size;
    }

    /**
     * @param UploadedFile $file
     * @param string $path
     * @return UploadedFile|mixed
     */
    public function createImage(UploadedFile $file, string $path = '')
    {
        $storagePath = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();
        $fileName = str_random(16) . '.' . $file->extension();

        $this->createDirectory($path);

        $fullPath = $storagePath . $path . $fileName;

        $image = Image::make($file)->fit(300)->save($fullPath);

        $file = $this->repository->create(['path' => $path . $image->basename, 'original_name' => $image->basename]);

        return $file;
    }

    /**
     * @param UploadedFile $file
     * @param string $disk
     * @param string $path
     * @return UploadedFile|mixed|\Symfony\Component\HttpFoundation\File\File
     */
    public function createFile(UploadedFile $file, string $disk, string $path = '')
    {
        $storagePath = Storage::disk($disk)->getDriver()->getAdapter()->getPathPrefix();
        $fileName = str_random(16) . '.' . $file->extension();

        $this->createDirectory($disk, $path);

        $file = $file->move($storagePath . $path, $fileName);

        $file = $this->repository->create(['path' => $path . $file->getBasename(), 'original_name' => $file->getBasename()]);

        return $file;
    }

    /**
     * @param string $disk
     * @param string $path
     * @return boolean
     */
    protected function createDirectory(string $disk, string $path): bool
    {
        return File::isDirectory($path) ? true : Storage::disk($disk)->makeDirectory($path);
    }
}
