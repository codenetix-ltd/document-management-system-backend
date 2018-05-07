<?php

namespace App\Http\Controllers;

use App\Http\Resources\FileResource;
use App\Services\File\FileCreateService;
use Illuminate\Http\Request;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class FileController extends Controller
{
    public function uploadFile(Request $request, FileCreateService $createService){
        $file = $request->file('file');
        $fileEntity = $createService->createFile($file, config('filesystems.paths.files'));

        return (new FileResource($fileEntity))->response()->setStatusCode(201);
    }
}
