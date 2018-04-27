<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class FileResource extends ApiResource
{
    protected function getComplexFields(Request $request): array
    {
        return [
            'name'=>$this->getOriginalName(),
            'url' => $this->getPath()
        ];
    }

    protected function getStructure(): array
    {
        return config('models.File');
    }
}
