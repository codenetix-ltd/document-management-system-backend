<?php

namespace App\Http\Resources;

use App\Services\AttributeService;
use Illuminate\Http\Resources\Json\JsonResource;

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
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => (new TypeResource($this->type))->toArray($request),
            'name' => $this->name,
            'data' => $this->attributeService->buildData($this->resource),
            'isLocked' => $this->isLocked,
            'order' => $this->order,
            'templateId' => $this->templateId,
            'createdAt' => $this->createdAt->timestamp,
            'updatedAt' => $this->updatedAt->timestamp
        ];
    }
}
