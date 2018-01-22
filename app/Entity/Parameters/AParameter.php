<?php

namespace App\Entity\Parameters;


/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
abstract class AParameter
{
    private $name;

    /**
     * AParameter constructor.
     * @param $name
     * @param $value
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    public abstract function getTypeName();
}