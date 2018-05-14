<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class PermissionResource extends BaseResource
{
    protected function getData(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'accessTypes' => AccessTypeResource::collection($this->accessTypes)->toArray($request),
            'createdAt' => $this->created_at->timestamp,
            'updatedAt' => $this->updated_at->timestamp
        ];
    }

    protected function getStructure(): array
    {
        return config('models.Permission');
    }


}
