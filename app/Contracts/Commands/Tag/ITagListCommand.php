<?php

namespace App\Contracts\Commands\Tag;

use App\Contracts\Models\ITag;
use Illuminate\Database\Eloquent\Collection;

interface ITagListCommand
{
    /**
     * @return Collection|ITag
     */
    public function getResult();
}