<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\Resource;

abstract class ApiResource extends Resource
{
    protected function getComplexFields(Request $request): array
    {
        return [];
    }

    protected abstract function getStructure(): array;

    public function toArray($request)
    {
        $response = [];
        $structure = $this->getStructure();
        foreach ($structure as $fieldKey => $fieldValue) {
            if (key_exists($fieldKey, static::getComplexFields($request))) {
                $response[$fieldKey] = static::getComplexFields($request)[$fieldKey];
                unset($structure[$fieldKey]);
            }
        }

        if ($structure) {
            $this->resource->setVisible(array_keys($structure));
            $data = $this->resource->toArray();
        } else {
            $data = [];
        }


        return array_merge($response, $data);
    }
}