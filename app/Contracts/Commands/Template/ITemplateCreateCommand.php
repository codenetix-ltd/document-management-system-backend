<?php

namespace App\Contracts\Commands\Template;

use App\Contracts\Models\ITemplate;

interface ITemplateCreateCommand
{
    /**
     * @return ITemplate
     */
    public function getResult();
}