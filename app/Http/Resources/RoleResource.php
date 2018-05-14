<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class RoleResource extends BaseResource
{
    protected function getStructure(): array
    {
        return config('models.Role');
    }

    protected function getData(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'templateIds' => $this->templates->pluck('id')->toArray(),
            'permissionValues' => PermissionValueResource::collection($this->permissions)->toArray($request),
            'createdAt' => $this->created_at->timestamp,
            'updatedAt' => $this->updated_at->timestamp
        ];
    }
}
