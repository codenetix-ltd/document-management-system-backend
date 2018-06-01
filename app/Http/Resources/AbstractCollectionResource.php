<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;

abstract class AbstractCollectionResource extends ResourceCollection
{
    /**
     * @param $item
     * @return mixed
     */
    abstract protected function transformSingle($item);

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function ($item) {
            return $this->transformSingle($item);
        });
        return parent::toArray($request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request)
    {
        return $this->resource instanceof AbstractPaginator
            ? (new CamelCasePaginatedResourceResponse($this))->toResponse($request)
            : parent::toResponse($request);
    }
}
