<?php

namespace App\Contracts\Services\Template;

use App\Template;

interface ITemplateCreateService
{
    public function create(Template $template) : Template;
}