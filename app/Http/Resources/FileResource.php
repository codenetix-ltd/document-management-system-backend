<?php

namespace App\Http\Resources;

use App\Entities\File;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property File $resource
 */
class FileResource extends JsonResource
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
            'url' => $this->resource->path
        ];
    }
}
