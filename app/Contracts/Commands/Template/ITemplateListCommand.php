<?php

namespace App\Contracts\Commands\Template;

use App\Contracts\Models\ITemplate;
use Illuminate\Database\Eloquent\Collection;

interface ITemplateListCommand
{
    /**
     * @return Collection|ITemplate
     */
    public function getResult();
}