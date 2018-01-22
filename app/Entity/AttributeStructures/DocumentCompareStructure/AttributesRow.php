<?php

namespace App\Entity\AttributeStructures\DocumentCompareStructure;
use App\Traits\Entity\HasTypeName;
use Illuminate\Support\Collection;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class AttributesRow
{
    use HasTypeName;

    private $name;
    private $attributes;
    private $maxValue;
    private $minValue;

    /**
     * @return mixed
     */
    public function getMaxValue(): string
    {
        return $this->maxValue;
    }

    /**
     * @param string $maxValue
     * @return string
     */
    public function setMaxValue(string $maxValue)
    {
        $this->maxValue = $maxValue;
    }

    /**
     * @return mixed
     */
    public function getMinValue()
    {
        return $this->minValue;
    }

    /**
     * @param mixed $minValue
     */
    public function setMinValue($minValue)
    {
        $this->minValue = $minValue;
    }

    public function getName(){
        return $this->name;
    }

    public function __construct($name)
    {
        $this->name = $name;
        $this->attributes = new Collection();
        $this->maxValue = 0;
        $this->minValue = 0;
    }

    public function addAttribute($attribute){
        $this->attributes->push($attribute);
    }

    public function getAttributes(){
        return $this->attributes;
    }

}