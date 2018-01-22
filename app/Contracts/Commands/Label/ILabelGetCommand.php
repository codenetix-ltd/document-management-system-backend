<?php

namespace App\Contracts\Commands\Label;

use App\Contracts\Models\ILabel;

interface ILabelGetCommand
{
    /**
     * @return ILabel
     */
    public function getResult();
}