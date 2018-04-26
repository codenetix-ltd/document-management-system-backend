<?php

namespace App\Http\Resources;

class TagResource extends ApiResource
{
    protected function getStructure(): array
    {
        return config('models.Label');
    }
}
