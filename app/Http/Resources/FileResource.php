<?php

namespace App\Http\Resources;

use App\Entities\File;
use Illuminate\Support\Facades\Storage;

/**
 * @property File $resource
 */
class FileResource extends AbstractSingularResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'name'=>$this->resource->originalName,
            'url' => url('/') . Storage::url($this->resource->path)
        ];
    }
}
