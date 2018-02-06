<?php

namespace App\Services\System;

use ReflectionClass;
use ReflectionMethod;

class Extractor
{
    public function extract($object, $fields = [])
    {
        if (!is_object($object)) {
            return [$object];
        }

        $transformedObject = [];

        $objectReflection = new ReflectionClass($object);

        foreach ($objectReflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            $key = $this->tryGetKey($method);

            if (!$key) {
                continue;
            }

            if (count($fields) && !in_array($key, $fields)) {
                continue;
            }

            $value = $this->getValue($object, $method);

            $transformedObject[$key] = $value;
        }

        return $transformedObject;
    }

    /**
     * @param ReflectionMethod $method
     * @return null|string
     */
    protected function tryGetKey(ReflectionMethod $method)
    {
        if (!is_getter($method->name)) {
            return null;
        }

        if (count($method->getParameters()) != 0) {
            return null;
        }

        $key = make_property($method->name);

        return $key;
    }

    /**
     * @param object $object
     * @param ReflectionMethod $method
     * @return mixed
     */
    protected function getValue($object, ReflectionMethod $method)
    {
        return $method->invoke($object);
    }
}
