<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class TagResource extends BaseResource
{
    protected function getStructure(): array
    {
        return config('models.Label');
    }

    protected function getData(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'createdAt' => $this->created_at->timestamp,
            'updatedAt' => $this->updated_at->timestamp
        ];
    }
}
