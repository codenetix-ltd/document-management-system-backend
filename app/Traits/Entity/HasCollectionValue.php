<?php
namespace App\Traits\Entity;
use Illuminate\Support\Collection;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
trait HasCollectionValue
{
    private $value;

    public function getValue(): Collection {
        return $this->value;
    }

    public function setValue(Collection $value): void
    {
        $this->value = $value;
    }
}