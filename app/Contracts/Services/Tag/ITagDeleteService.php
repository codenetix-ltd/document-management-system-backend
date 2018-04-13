<?php

namespace App\Contracts\Services\Tag;

interface ITagDeleteService
{
    public function delete(int $id) : ?bool;
}