<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class LogResource extends ApiResource
{
    protected function getComplexFields(Request $request): array
    {
        return [
            'user' => (new UserResource($this->user))->toArray($request),
            'action' => $this->body,
        ];
    }

    protected function getStructure(): array
    {
        return config('models.Log');
    }
}
