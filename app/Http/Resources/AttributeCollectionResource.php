<?php

namespace App\Http\Resources;

use App\Services\AttributeService;

class AttributeCollectionResource extends AbstractCollectionResource
{
    /**
     * @var AttributeService
     */
    private $attributeService;

    /**
     * AttributeCollectionResource constructor.
     * @param $resource
     * @param AttributeService $attributeService
     */
    public function __construct($resource, AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;
        parent::__construct($resource);
    }

    /**
     * @param $item
     * @return AttributeResource|mixed
     */
    protected function transformSingle($item)
    {
        return new AttributeResource($item, $this->attributeService);
    }
}
