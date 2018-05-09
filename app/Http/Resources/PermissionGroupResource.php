<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class PermissionGroupResource extends ApiResource
{
    protected function getComplexFields(Request $request): array
    {
        return [
            'permissions' => PermissionResource::collection($this->permissions)->toArray($request),
            'qualifiers' => QualifierResource::collection($this->qualifiers)->toArray($request)
        ];
    }

    protected function getStructure(): array
    {
        return config('models.PermissionGroup');
    }
}
