<?php

namespace App\Entity;


/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class ValueWithDeviations
{
    private $leftDeviation;
    private $value;
    private $rightDeviation;

    /**
     * ValueWithDeviations constructor.
     * @param $leftDeviation
     * @param $value
     * @param $rightDeviation
     */
    public function __construct(string $leftDeviation = null, string $value = null, string $rightDeviation = null)
    {
        $this->leftDeviation = $leftDeviation;
        $this->value = $value;
        $this->rightDeviation = $rightDeviation;
    }

    /**
     * @return string
     */
    public function getLeftDeviation(): ?string
    {
        return $this->leftDeviation;
    }

    /**
     * @param string $leftDeviation
     */
    public function setLeftDeviation(string $leftDeviation)
    {
        $this->leftDeviation = $leftDeviation;
    }

    /**
     * @return string
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getRightDeviation(): ?string
    {
        return $this->rightDeviation;
    }

    /**
     * @param string $rightDeviation
     */
    public function setRightDeviation(string $rightDeviation)
    {
        $this->rightDeviation = $rightDeviation;
    }
}