<?php

namespace App\Entity\Parameters;
use App\Contracts\Entity\IHasStringValue;
use App\Traits\Entity\HasStringValue;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class StringParameter extends AParameter implements IHasStringValue
{
    use HasStringValue;

    public function __construct(string $name, string $value)
    {
        parent::__construct($name);
        $this->value = $value;
    }

    public function getTypeName()
    {
        return 'string';
    }
}