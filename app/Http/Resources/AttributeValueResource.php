<?php

namespace App\Http\Resources;

use App\Attribute;
use Illuminate\Http\Request;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class AttributeValueResource extends ApiResource
{
    protected function getComplexFields(Request $request): array
    {
        /** @var Attribute $attribute */
        $attribute = $this->attribute;
        return [
            'id' => $attribute->getId(),
            'type' => $attribute->type->machine_name
        ];
    }

    protected function getStructure(): array
    {
        //TODO id, name, value properties are required
        return config('models.ValueInteger');
    }
}
