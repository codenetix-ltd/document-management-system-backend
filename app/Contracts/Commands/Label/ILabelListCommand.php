<?php

namespace App\Contracts\Commands\Label;

use App\Contracts\Models\ILabel;
use Illuminate\Database\Eloquent\Collection;

interface ILabelListCommand
{
    /**
     * @return Collection|ILabel
     */
    public function getResult();
}