<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class TypeResource extends BaseResource
{
    protected function getStructure(): array
    {
        return config('models.Type');
    }

    protected function getData(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'machineName' => $this->machine_name
        ];
    }
}
