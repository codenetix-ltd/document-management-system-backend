<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
abstract class AbstractCollectionResource extends ResourceCollection
{
    abstract protected function transformSingle($item);

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function ($item) {
            return $this->transformSingle($item);
        });
        return parent::toArray($request);
    }

    public function toResponse($request)
    {
        return $this->resource instanceof AbstractPaginator
            ? (new CamelCasePaginatedResourceResponse($this))->toResponse($request)
            : parent::toResponse($request);
    }
}
