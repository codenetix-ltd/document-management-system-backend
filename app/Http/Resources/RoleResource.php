<?php

namespace App\Http\Resources;

class RoleResource extends ApiResource
{
    protected function getStructure(): array
    {
        return config('models.Role');
    }
}
