<?php

namespace App\Http\Resources;

use App\Entities\Attribute;
use App\Services\AttributeService;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AttributeCollectionResource extends ResourceCollection
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
        $this->collection->transform(function (Attribute $user) {
            return new AttributeResource($user, $this->attributeService);
        });

        return parent::toArray($request);
    }
}
