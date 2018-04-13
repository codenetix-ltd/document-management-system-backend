<?php

namespace App\Contracts\System;

interface ITransformer
{
    public function transform(array $data, $object);

    public function getTransformedFields(): array;
}