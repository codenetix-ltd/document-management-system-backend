<?php


namespace App\Entity;

use App\Contracts\Attributes\ITableAttribute;
use App\Contracts\Attributes\ITableRow;
use App\Contracts\Entity\IHasId;
use App\Contracts\Entity\IHasName;
use App\Traits\Entity\HasId;
use App\Traits\Entity\HasName;
use Illuminate\Support\Collection;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
abstract class ABaseTableRow
{
    private $cells;

    /**
     * ABaseTableRow constructor.
     */
    public function __construct()
    {
        $this->cells = new Collection();
    }

    public function addCell($attribute)
    {
        $this->cells->push($attribute);
    }

    public function getCells(): Collection
    {
        return $this->cells;
    }

}