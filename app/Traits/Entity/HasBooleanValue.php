<?php
namespace App\Traits\Entity;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
trait HasBooleanValue
{
    private $value;

    public function getValue(): ?bool {
        return $this->value;
    }

    public function setValue(bool $value): void
    {
        $this->value = $value;
    }
}