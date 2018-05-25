<?php

namespace App\Http\Resources;

use App\Services\AttributeService;

class AttributeCollectionResource extends AbstractCollectionResource
{
    private $attributeService;

    public function __construct($resource, AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;
        parent::__construct($resource);
    }

    protected function transformSingle($item)
    {
        return new AttributeResource($item, $this->attributeService);
    }
}
