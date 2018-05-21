<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class UserResource extends BaseResource
{
    protected function getData(Request $request): array
    {
        return [
            'id' => $this->id,
            'fullName' => $this->full_name,
            'email' => $this->email,
            'templatesIds' => $this->templates->pluck('id'),
            'avatar' => $this->when($this->avatar, new AvatarResource($this->avatar))
        ];
    }

    protected function getStructure(): array
    {
        return config('models.User');
    }
}
