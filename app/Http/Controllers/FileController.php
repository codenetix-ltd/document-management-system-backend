<?php

namespace App\Http\Controllers;

use App\Http\Resources\FileResource;
use App\Services\FileService;
use Illuminate\Http\Request;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class FileController extends Controller
{
    /**
     * @param Request $request
     * @param FileService $createService
     *
     * @return FileResource
     */
    public function uploadFile(Request $request, FileService $createService)
    {
        $file = $request->file('file');
        $fileEntity = $createService->createFile($file, config('filesystems.paths.files'));

        return (new FileResource($fileEntity));
    }
}
