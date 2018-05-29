<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\PaginatedResourceResponse;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class CamelCasePaginatedResourceResponse extends PaginatedResourceResponse
{
    protected function meta($paginated)
    {
        $meta = parent::meta($paginated);

        return array_combine(array_map(function ($item) {
            return camel_case($item);
        }, array_keys($meta)), array_values($meta));
    }
}
