<?php

namespace App\Contracts\Services\Template;

use App\Template;

interface ITemplateGetService
{
    public function get(int $id) : Template;
}