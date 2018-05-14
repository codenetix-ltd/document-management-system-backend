<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class AccessTypeResource extends BaseResource
{
    protected function getStructure(): array
    {
        return config('models.AccessType');
    }

    protected function getData(Request $request): array
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'createdAt' => $this->created_at->timestamp,
            'updatedAt' => $this->updated_at->timestamp
        ];
    }
}
