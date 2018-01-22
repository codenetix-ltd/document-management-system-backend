<?php

namespace App\Entity\Parameters;

use App\Contracts\Entity\IHasNumericValue;
use App\Traits\Entity\HasNumericValue;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class NumericParameter extends AParameter implements IHasNumericValue
{
    use HasNumericValue;

    public function __construct(string $name, string $value)
    {
        parent::__construct($name);
        $this->value = $value;
    }

    public function getTypeName()
    {
        return 'numeric';
    }
}