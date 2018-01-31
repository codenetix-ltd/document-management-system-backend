<?php

namespace App\Contracts\Transformers;

//TODO - переименовать, удалить
interface IUpdateRequestTransformer
{
    public function getUpdatedFields(): array;
}