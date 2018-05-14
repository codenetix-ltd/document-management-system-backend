<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\Resource;

abstract class BaseResource extends Resource
{
    protected abstract function getStructure(): array;

    protected abstract function getData(Request $request): array;

    public function toArray($request)
    {
        return array_intersect_key($this::getData($request), $this->getStructure());
    }
}