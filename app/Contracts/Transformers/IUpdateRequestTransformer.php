<?php

namespace App\Contracts\Transformers;

interface IUpdateRequestTransformer
{
    public function getUpdatedFields(): array;
}