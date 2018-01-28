<?php

namespace App\Contracts\Repositories;

use App\Contracts\Models\IFile;

interface IFileRepository
{
    public function create(array $data) : IFile;
}