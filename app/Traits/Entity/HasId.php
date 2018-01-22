<?php
namespace App\Traits\Entity;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
trait HasId
{
    private $id;

    public function getId(): int{
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}