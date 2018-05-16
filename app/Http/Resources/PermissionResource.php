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
            'label' => $this->label,
            'accessTypes' => AccessTypeResource::collection($this->accessTypes)->toArray($request)
        ];
    }

    protected function getStructure(): array
    {
        return config('models.Permission');
    }


}