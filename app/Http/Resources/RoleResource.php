<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class RoleResource extends ApiResource
{
    protected function getComplexFields(Request $request): array
    {
        return [
            'templateIds' => $this->templates->pluck('id'),
            'permissionValues' => PermissionValueResource::collection($this->permissions)->toArray($request)
        ];
    }

    protected function getStructure(): array
    {
        return config('models.Role');
    }
}
