<?php

namespace App\Repositories;

use App\Contracts\Models\IFile;
use App\Contracts\Repositories\IFileRepository;
use App\File;

class FileRepository implements IFileRepository
{
    public function create(array $data): IFile
    {
        $file = new File();
        //TODO - remove fill from here
        $file->fill($data);
        $file->save();

        return $file;
    }
}