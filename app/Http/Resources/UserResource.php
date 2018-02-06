<?php

namespace App\Http\Resources;

class UserResource extends ApiResource
{
    protected function getComplexFields(): array
    {
        //TODO - можно ли тут так
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
