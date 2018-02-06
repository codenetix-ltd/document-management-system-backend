<?php

namespace App\Services\System;

use App\Contracts\System\ITransformer;
use ReflectionClass;
use ReflectionMethod;

class Transformer implements ITransformer
{
    private $transformedFields = [];

    public function transform(array $data, $object, array $modelStructure = [])
    {
        $objectReflection = new ReflectionClass($object);

        foreach ($data as $field => $value) {
            if (count($modelStructure) && !in_array($field, $modelStructure)) {
                continue;
            }

            $method = $this->tryGetSetterName($data, $field, $objectReflection);

            if (!$method) {
                continue;
            }

            $value = $this->getValue($data, $field);
            $this->addTransformedField($field);

            $method->invoke($object, $value);
        }

        return $object;
    }

    /**
     * @return array
     */
    public function getTransformedFields(): array
    {
        return $this->transformedFields;
    }

    /**
     * @param $field
     */
    private function addTransformedField($field)
    {
        array_push($this->transformedFields,$field);
    }

    /**
     * @param array $data
     * @param string $field
     * @return mixed
     */
    private function getValue(array $data, $field)
    {
        return $data[$field];
    }

    /**
     * @param array $data
     * @param string $field
     * @return bool
     */
    private function hasValue(array $data, $field)
    {
        return isset($data[$field]);
    }

    /**
     * Checks whether the setter can be processed
     *
     * @param array $data
     * @param string $field
     * @param ReflectionClass $objectReflection
     * @return ReflectionMethod|null
     */
    private function tryGetSetterName(array $data, $field, ReflectionClass $objectReflection)
    {
        if (is_getter($field, ['has'])) {
            return null;
        }
        $methodName = make_setter($field);

        if (!$objectReflection->hasMethod($methodName)) {
            return null;
        }

        $setter = $objectReflection->getMethod($methodName);

        if (!$setter->isPublic()) {
            return null;
        }

        if (!is_setter($setter->name)) {
            return null;
        }

        if (!$this->hasValue($data, $field)) {
            return null;
        }

        if (count($setter->getParameters()) != 1) {
            return null;
        }

        return $setter;
    }
}
