<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class BaseEntity extends Model
{
    public function getAttribute($key)
    {
        if (array_key_exists($key, $this->relations)) {
            return parent::getAttribute($key);
        } elseif (method_exists($this, $key)) {
            return parent::getAttribute($key);
        } else {
            return parent::getAttribute(snake_case($key));
        }
    }

    public function setAttribute($key, $value)
    {
        return parent::setAttribute(snake_case($key), $value);
    }

    public function toArray()
    {
        $data = parent::toArray();
        $result = [];
        foreach ($data as $key => $item) {
            $result[camel_case($key)] = $item;
        }

        return $result;
    }
}