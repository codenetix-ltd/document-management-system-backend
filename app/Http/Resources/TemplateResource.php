<?php

namespace App\Http\Resources;

class TemplateResource extends ApiResource
{
    protected function getStructure(): array
    {
        return config('models.Template');
    }
}
