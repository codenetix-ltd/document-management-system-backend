<?php

namespace App\Contracts\System;

interface ITransformer
{
    public function transform(array $data, $object, array $modelStructure = []);

    public function getTransformedFields(): array;
}