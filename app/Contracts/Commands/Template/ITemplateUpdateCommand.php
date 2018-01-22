<?php

namespace App\Contracts\Commands\Template;

use App\Contracts\Models\ITemplate;

interface ITemplateUpdateCommand
{
    /**
     * @return ITemplate
     */
    public function getResult();
}