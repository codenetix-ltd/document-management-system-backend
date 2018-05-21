<?php

namespace App\Http\Resources;

use App\File;
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
            'name'=>$this->resource->getOriginalName(),
            'url' => $this->resource->getPath()
        ];
    }
}
