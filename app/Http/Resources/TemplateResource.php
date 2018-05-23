<?php

namespace App\Http\Resources;

use App\Entities\Template;
use App\Services\AttributeService;
use Illuminate\Http\Resources\Json\Resource;

/**
 * Class TemplateResource
 * @package App\Http\Resources
 *
 * @property Template $resource
 */
class TemplateResource extends Resource
{
    public function toArray($request)
    {
        $attributeService = app()->make(AttributeService::class);

        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'attributes' => new AttributeCollectionResource($this->resource->attributes, $attributeService),
            'createdAt' => $this->resource->createdAt->timestamp,
            'updatedAt' => $this->resource->updatedAt->timestamp
        ];
    }
}
