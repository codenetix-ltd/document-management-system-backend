<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class UserResource extends ApiResource
{
    protected function getComplexFields(Request $request): array
    {
        return [
            'templatesIds' => $this->templates->pluck('id'),
            'avatar' => $this->when($this->avatar, new AvatarResource($this->avatar))
        ];
    }

    protected function getStructure(): array
    {
        return config('models.user_response');
    }
}
