<?php

namespace App\Services\System;

use App\Contracts\System\ITransformer;
use Illuminate\Database\Eloquent\Model;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class EloquentTransformer implements ITransformer
{
    private $updatedFields = [];
    public function transform(array $data, Model $object)
    {
        $convertedData = [];
        foreach($data as $k=>$v) {
            //TODO remove updated fields logic from project
            $this->updatedFields[] = $k;
            $convertedData[snake_case($k)] = $v;
        }
        $object->fill($convertedData);

        return $object;
    }

    public function getTransformedFields(): array
    {
        return $this->updatedFields;
    }
}
