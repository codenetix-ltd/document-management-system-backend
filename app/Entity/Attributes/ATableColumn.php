<?php

namespace App\Entity\Attributes;

use App\Contracts\Attributes\IAttribute;
use App\Contracts\Attributes\IComposite;
use App\Contracts\Attributes\ITableColumn;
use App\Contracts\Entity\IHasId;
use App\Contracts\Entity\IHasName;
use App\Entity\ABaseTableColumn;
use App\Traits\Entity\HasId;
use App\Traits\Entity\HasName;
use App\Traits\Entity\HasTypeName;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class ATableColumn extends ABaseTableColumn implements IHasName, IHasId
{
    use HasId;
    use HasName;
    use HasTypeName;

    private $typeId;

    public function __construct(int $id, string $name, int $typeId, string $typeName)
    {
        $this->id = $id;
        $this->name = $name;
        $this->typeId = $typeId;
        $this->typeName = $typeName;
    }
}