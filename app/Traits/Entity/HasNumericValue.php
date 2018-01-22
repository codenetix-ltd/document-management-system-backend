<?php
namespace App\Traits\Entity;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
trait HasNumericValue
{
    private $value;

    public function getValue(): ?string {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}