<?php

namespace App\Http\Resources;

use App\Services\AttributeService;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeResource extends JsonResource
{
    private $attributeService;

    public function __construct(mixed $resource, AttributeService $attributeService)
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
            'data' => $this->resource->getData(),
            'createdAt' => $this->createdAt->timestamp,
            'updatedAt' => $this->updatedAt->timestamp
        ];
    }
}
