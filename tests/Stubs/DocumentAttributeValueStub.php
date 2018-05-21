<?php

namespace Tests\Stubs\Requests;

use App\Entities\Attribute;
use Tests\Stubs\StubInterface;

class DocumentAttributeValueStub implements StubInterface
{

    public function buildModel($valuesToOverride = [], $persisted = false){
        $attribute = factory(Attribute::class)->create();

        return [
            'id' => $attribute->id,
            'value' => 'testValue',
        ];
    }

    public function buildRequest()
    {
        return [];
    }

    public function getModel()
    {
        return [];
    }
}