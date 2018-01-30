<?php

namespace App\Contracts\Transformers;

use App\Contracts\Models\IUser;

interface IUserRequestTransformer extends IUpdateRequestTransformer
{
    public function getEntity(): IUser;
}