<?php

namespace App\Http\Resources;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class ArrayResource extends ApiResource
{
    /**
     * @var string
     */
    private $apiResourceClass;

    public function __construct($resource, string $apiResourceClass)
    {
        parent::__construct($resource);
        $this->apiResourceClass = $apiResourceClass;
    }

    public function toArray($request)
    {
        $result = [];
        foreach ($this->resource as $v) {
            $result[] = (new $this->apiResourceClass($v))->toArray($request);
        }

        return $result;
    }

    protected function getStructure(): array
    {
        return [];
    }
}
