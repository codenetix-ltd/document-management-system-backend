<?php

namespace App\Contracts\Services\Template;

interface ITemplateDeleteService
{
    public function delete(int $id) : ?bool;
}