<?php

namespace App\Commands\Type;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\Type\ITypeListCommand;
use App\Contracts\Models\IType;
use App\Type;
use Illuminate\Database\Eloquent\Collection;

class TypeListCommand extends ACommand implements ITypeListCommand
{
    /** @var array $columns */
    private $columns;

    /** @var Collection|IType $collection */
    private $collection;

    /**
     * TypeListCommand constructor.
     * @param array $columns
     */
    public function __construct($columns = ['*'])
    {
        $this->columns = $columns;
    }

    /**
     * @return Collection|IType
     */
    public function getResult()
    {
        $this->isExecuted();

        return $this->collection;
    }

    /**
     * @return void
     */
    public function execute()
    {
        $this->collection = Type::all($this->columns);

        $this->executed = true;
    }
}
