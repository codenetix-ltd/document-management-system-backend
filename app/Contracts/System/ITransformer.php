<?php

namespace App\Contracts\System;

use Illuminate\Database\Eloquent\Model;

interface ITransformer
{
    public function transform(array $data, Model $object);

    public function getTransformedFields(): array;
}