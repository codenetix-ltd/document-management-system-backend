<?php

namespace App\Entity\AttributeStructures;

use Illuminate\Support\Collection;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class DocumentCompareStructure
{
    private $rows;

    private $documents;

    public function __construct()
    {
        $this->rows = new Collection();
        $this->documents = new Collection();
    }

    public function addRow($row)
    {
        $this->rows->push($row);
    }

    public function setDocuments($documents)
    {
        $this->documents = $documents;
    }

    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @return mixed
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param mixed $columns
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;
    }

    /**
     * @return mixed
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @param mixed $rows
     */
    public function setRows($rows)
    {
        $this->rows = $rows;
    }

}