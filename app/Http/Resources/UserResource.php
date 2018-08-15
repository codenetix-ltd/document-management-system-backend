<?php

namespace App\Http\Resources;

use App\Entities\User;
use App\Facades\AuthPermissions;
use Illuminate\Http\Request;

/**
 * Class UserResource
 * @package App\Http\Resources
 *
 * @property User $resource
 */
class UserResource extends AbstractSingularResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'fullName' => $this->resource->fullName,
            'email' => $this->resource->email,
            'templatesIds' => $this->resource->templates->pluck('id')->toArray(),
            'avatar' => $this->resource->avatar ? new FileResource($this->resource->avatar) : null,
            'avatarId' => $this->resource->avatar ? $this->resource->avatar->id : null,
            'rolesIds' => $this->resource->roles->pluck('id'),
            'roles' => $request->route('user') == 'current' ? RoleResource::collection($this->resource->roles) : null,
            'authPermissions' => AuthPermissions::getList('user', $this->resource),
        ];
    }
}
