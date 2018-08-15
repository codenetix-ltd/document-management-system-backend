<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
abstract class AbstractSingularResource extends JsonResource
{
    /**
     * @param Request $request
     *
     * @return array
     */
    protected function getMeta($request)
    {
        return [];
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function with($request)
    {
        return static::$wrap ? ['meta' => $this->getMeta($request)] : [];
    }
}
