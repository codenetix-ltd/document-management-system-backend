<?php

namespace App\Entity\Parameters;
use App\Entity\ABaseTable;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class TableParameter extends AParameter
{
    private $value;

    public function __construct(string $name, ABaseTable $value)
    {
        parent::__construct($name);
        $this->value = $value;
    }

    public function getValue() : ABaseTable
    {
        return $this->value;
    }

    public function setValue(ABaseTable $value) : void
    {
        $this->value = $value;
    }

    public function getTypeName()
    {
        return 'table';
    }
}