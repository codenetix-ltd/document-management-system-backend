<?php

namespace App\Http\Resources;

use App\Entities\Attribute;
use App\Services\AttributeService;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class AttributeResource
 * @package App\Http\Resources
 *
 * @property Attribute $resource
 */
class AttributeResource extends JsonResource
{
    private $attributeService;

    public function __construct($resource, AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'type' => (new TypeResource($this->resource->type))->toArray($request),
            'name' => $this->resource->name,
            'data' => $this->attributeService->buildData($this->resource),
            'isLocked' => $this->resource->isLocked,
            'order' => $this->resource->order,
            'templateId' => $this->resource->templateId,
            'createdAt' => $this->resource->createdAt->timestamp,
            'updatedAt' => $this->resource->updatedAt->timestamp
        ];
    }
}
