<?php

namespace App\Http\Resources;

use App\Entities\Template;
use App\Facades\AuthPermissions;
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
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $attributeService = app()->make(AttributeService::class);

        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'attributes' => new AttributeCollectionResource($this->resource->attributes, $attributeService),
            'createdAt' => $this->resource->createdAt->timestamp,
            'updatedAt' => $this->resource->updatedAt->timestamp,
            'authPermissions' => AuthPermissions::getList('template', $this->resource)
        ];
    }
}
