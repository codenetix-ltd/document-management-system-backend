<?php

namespace App\Entity\Parameters;

use App\Contracts\Entity\IHasName;
use App\Entity\ABaseTableRow;
use App\Traits\Entity\HasName;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class TableRow extends ABaseTableRow implements IHasName
{
    use HasName;

    private $name;

    /**
     * TableRow constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        parent::__construct();
        $this->name = $name;
    }
}