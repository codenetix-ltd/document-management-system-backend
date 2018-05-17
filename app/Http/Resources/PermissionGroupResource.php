<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionGroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'permissions' => PermissionResource::collection($this->permissions)->toArray($request),
            'qualifiers' => QualifierResource::collection($this->qualifiers)->toArray($request)
        ];
    }
}
