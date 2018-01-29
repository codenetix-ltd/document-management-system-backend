<?php

namespace App\Contracts\Transformers;

use App\Contracts\Models\IUser;

interface IUserRequestTransformer
{
    public function getEntity(): IUser;

    public function getUpdatedFields(): array;
}