<?php

namespace App\Http\Resources;

use App\Entities\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 * @package App\Http\Resources
 *
 * @property User $resource
 */
class UserResource extends JsonResource
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
            'avatar' => new FileResource($this->resource->avatar),
            'avatarId' => $this->resource->avatar->id,
        ];
    }
}
