<?php

namespace App\Contracts\Commands\Role;

interface IRoleListCommand
{
    /**
     * @return array
     */
    public function getResult();
}