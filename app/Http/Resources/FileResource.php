<?php

namespace App\Http\Resources;

use App\Entities\File;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 *
 * @property File $resource
 */
class FileResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'name'=>$this->resource->originalName,
            'url' => $this->resource->path
        ];
    }
}
