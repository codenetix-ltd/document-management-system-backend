<?php

namespace App\Http\Resources;

class AccessTypeResource extends ApiResource
{
    protected function getStructure(): array
    {
        return config('models.AccessType');
    }
}
