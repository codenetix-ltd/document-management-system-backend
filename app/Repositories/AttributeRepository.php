<?php

namespace App\Repositories;

use App\AttributeValue;
use App\Contracts\Models\IAttribute;
use App\Contracts\Repositories\IAttributeRepository;

class AttributeRepository implements IAttributeRepository
{
    public function getAttributeValuesByDocumentVersionId($documentVersionId){
        return AttributeValue::whereDocumentVersionId($documentVersionId)->get();
    }

    public function create(IAttribute $attribute): IAttribute
    {
        // TODO: Implement create() method.
    }
}