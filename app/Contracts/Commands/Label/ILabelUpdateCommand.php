<?php

namespace App\Contracts\Commands\Label;

use App\Contracts\Models\ILabel;

interface ILabelUpdateCommand
{
    /**
     * @return ILabel
     */
    public function getResult();
}