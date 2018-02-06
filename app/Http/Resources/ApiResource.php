<?php

namespace App\Http\Resources;

use App\Services\System\Extractor;
use Illuminate\Http\Resources\Json\Resource;

abstract class ApiResource extends Resource
{
    protected function getComplexFields(): array
    {
        return [];
    }

    protected abstract function getStructure(): array;

    public function toArray($request)
    {
        $response = [];
        $structure = $this->getStructure();
        foreach ($structure as $fieldKey => $fieldValue) {
            if (key_exists($fieldKey, static::getComplexFields())) {
                $response[$fieldKey] = static::getComplexFields()[$fieldKey];
                unset($structure[$fieldKey]);
            }
        }
        $extractor = new Extractor();
        $data = $extractor->extract($this->resource, $structure);

        return array_merge($response, $data);
    }
}