<?php

namespace App\Http\Resources;

class TypeResource extends ApiResource
{
    protected function getStructure(): array
    {
        return config('models.type_response');
    }
}
