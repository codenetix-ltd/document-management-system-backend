<?php

namespace App\Contracts\Commands\Template;

use App\Contracts\Models\ITemplate;

interface ITemplateGetCommand
{
    /**
     * @return ITemplate
     */
    public function getResult();
}