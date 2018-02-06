<?php

namespace App\Http\Resources;

class TypeResource extends ApiResource
{
    protected function getStructure(): array
    {
        return config('models.template_response');
    }
}
