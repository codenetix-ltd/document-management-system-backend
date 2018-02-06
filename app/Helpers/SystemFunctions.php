<?php
/**
 * The function determines whether the method is getter
 *
 * @param string $method
 * @param array $types
 * @return bool
 */
function is_getter($method, $types = ['get', 'is', 'has', 'can'])
{
    $typesStr = implode('|', $types);

    return (bool)preg_match("/^({$typesStr})[A-Z0-9]/", $method);
}


/**
 * The function determines whether the method is setter
 *
 * @param string $method
 * @return bool
 */
function is_setter($method)
{
    return (bool)preg_match('/^set[A-Z0-9]/', $method);
}

/**
 * Creates setter name from property name
 *
 * @param string $property
 * @return string
 * @throws RuntimeException
 */
function make_setter($property)
{
    $matches = [];

    if (preg_match('/^(?:is|has|can)([A-Z0-9].*)/', $property, $matches)) {
        return 'set' . ucfirst($matches[1]);
    }

    return 'set' . ucfirst($property);
}

/**
 * The function resolves the property name from getter or setter
 *
 * @param $method
 * @param bool $real - if it is "true" the prefix "is" and "has" will be dropped
 * @return string
 * @throws RuntimeException
 */
function make_property($method, $real = false)
{
    $matches = [];

    if (!preg_match('/^(set|get|is|has|can)([A-Z0-9].*)/', $method, $matches)) {
        throw new RuntimeException('The method "' . $method . '" must be either getter or setter.');
    }

    if (!$real && in_array($matches[1], ['is', 'has', 'can'])) {
        return $method;
    }

    return lcfirst($matches[2]);
}


//TODO - remove
function dms_build_getter($fieldKey) {
    return 'get' . ucfirst(camel_case($fieldKey));
}

function dms_build_setter($fieldKey) {
    return 'set' . ucfirst(camel_case($fieldKey));
}


