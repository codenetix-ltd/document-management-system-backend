<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class AccessTypeResource extends ApiResource
{
    protected function getComplexFields(Request $request): array
    {
        return [
            'id' => $this->name,
        ];
    }

    protected function getStructure(): array
    {
        return config('models.AccessType');
    }
}
