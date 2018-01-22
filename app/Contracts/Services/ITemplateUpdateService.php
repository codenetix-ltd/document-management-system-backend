<?php

namespace App\Contracts\Services;

use App\Contracts\Models\ITemplate;

interface ITemplateUpdateService
{
    /**
     * @return ITemplate
     */
    public function getResult();
}