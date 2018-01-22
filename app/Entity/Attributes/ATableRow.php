<?php

namespace App\Entity\Attributes;

use App\Contracts\Attributes\ITableAttribute;
use App\Contracts\Attributes\ITableRow;
use App\Contracts\Entity\IHasId;
use App\Contracts\Entity\IHasName;
use App\Entity\ABaseTableRow;
use App\Traits\Entity\HasId;
use App\Traits\Entity\HasName;
use Illuminate\Support\Collection;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
abstract class ATableRow extends ABaseTableRow implements IHasName, IHasId
{
    use HasName;
    use HasId;

    public function __construct(int $id, string $name)
    {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
    }

}