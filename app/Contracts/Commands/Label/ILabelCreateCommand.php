<?php

namespace App\Contracts\Commands\Label;

use App\Contracts\Models\ILabel;

interface ILabelCreateCommand
{
    /**
     * @return ILabel
     */
    public function getResult();
}