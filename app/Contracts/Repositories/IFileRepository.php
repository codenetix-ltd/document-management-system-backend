<?php

namespace App\Contracts\Repositories;

use App\File;

interface IFileRepository
{
    public function create(array $data) : File;
}