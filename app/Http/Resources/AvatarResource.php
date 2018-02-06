<?php

namespace App\Http\Resources;

class AvatarResource extends ApiResource
{
    protected function getStructure(): array
    {
        return config('models.avatar');
    }
}
