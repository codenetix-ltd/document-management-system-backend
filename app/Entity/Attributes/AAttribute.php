<?php

namespace App\Entity\Attributes;
use App\Contracts\Entity\IHasId;
use App\Contracts\Entity\IHasName;
use App\Traits\Entity\HasId;
use App\Traits\Entity\HasName;


/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
abstract class AAttribute implements IHasName, IHasId
{
    use HasName;
    use HasId;

    private $typeId;

    private $isLocked;

    public function __construct(int $id, string $name, int $typeId, string $typeName, bool $isLocked)
    {
        $this->id = $id;
        $this->name = $name;
        $this->typeId = $typeId;
        $this->isLocked = $isLocked;
    }

    public abstract function getTypeName() : string;

    public function isLocked(){
        return $this->isLocked;
    }

    public function setIsLocked($isLocked){
        $this->isLocked = $isLocked;
    }

}