<?php

namespace App\Entity;

use App\Contracts\Attributes\ITableColumn;
use App\Contracts\Entity\IHasId;
use App\Contracts\Entity\IHasName;
use App\Traits\Entity\HasId;
use App\Traits\Entity\HasName;
use Illuminate\Support\Collection;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
abstract class ABaseTable
{
    private $rows;
    private $columns;

    public function __construct()
    {
        $this->rows = new Collection();
        $this->columns = new Collection();
    }

    public function addRow(ABaseTableRow $row)
    {
        $this->rows->push($row);
    }

    public function addColumn(ABaseTableColumn $column)
    {
        $this->columns->push($column);
    }

    public function getColumns(){
        return $this->columns;
    }

    public function getRows(){
        return $this->rows;
    }
}