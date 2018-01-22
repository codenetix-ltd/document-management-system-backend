<?php

namespace App\Entity\Attributes;

use App\Contracts\Attributes\ITableColumn;
use App\Contracts\Entity\IHasId;
use App\Contracts\Entity\IHasName;
use App\Entity\ABaseTable;
use App\Traits\Entity\HasId;
use App\Traits\Entity\HasName;
use Illuminate\Support\Collection;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
abstract class ATable extends ABaseTable implements IHasName, IHasId
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