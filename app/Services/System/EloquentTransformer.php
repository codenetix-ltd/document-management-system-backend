<?php

namespace App\Services\System;

use App\Contracts\System\ITransformer;
use Illuminate\Database\Eloquent\Model;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class EloquentTransformer implements ITransformer
{

    public function transform(array $data, Model $object)
    {
        $convertedData = [];
        foreach($data as $k=>$v) {
            $convertedData[snake_case($k)] = $v;
        }
        $object->fill($convertedData);

        return $object;
    }

    public function getTransformedFields(): array
    {
        return [];
    }
}
