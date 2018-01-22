<?php

namespace App\Commands\Factory;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\Factory\IFactoryListCommand;
use App\Contracts\Models\IFactory;
use App\Factory;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Collection;

class FactoryListCommand extends ACommand implements IFactoryListCommand
{
    /** @var array $columns */
    private $columns;

    /** @var array $ids */
    private $ids;

    /** @var Collection|IFactory $collection */
    private $collection;

    private $strict;

    public function __construct(Container $container, $columns = ['*'], array $ids = [], $strict = false)
    {
        parent::__construct($container);
        $this->columns = $columns;
        $this->ids = $ids;
        $this->strict = $strict;
    }

    /**
     * @return Collection|IFactory
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
        $query = Factory::query();
        if (count($this->ids) || $this->strict) {
            $query->whereIn('id', $this->ids);
        }
        $this->collection = $query->get($this->columns);

        $this->executed = true;
    }
}
