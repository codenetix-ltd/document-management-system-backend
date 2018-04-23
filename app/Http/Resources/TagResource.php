<?php

namespace App\Http\Resources;

class TagResource extends ApiResource
{
    protected function getStructure(): array
    {
        //TODO There is no model tag in documentation
        return [
            'id',
            'name',
            'createdAt',
            'updatedAt'
        ];
    }
}
