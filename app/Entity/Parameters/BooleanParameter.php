<?php

namespace App\Entity\Parameters;
use App\Contracts\Entity\IHasBooleanValue;
use App\Traits\Entity\HasBooleanValue;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class BooleanParameter extends AParameter implements IHasBooleanValue
{
    use HasBooleanValue;

    public function __construct(string $name, bool $value)
    {
        parent::__construct($name);
        $this->value = $value;
    }

    public function getTypeName()
    {
        return 'boolean';
    }
}