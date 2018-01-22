<?php

namespace App\Commands\Label;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\Label\ILabelListCommand;
use App\Contracts\Models\ILabel;
use App\Label;
use Illuminate\Database\Eloquent\Collection;

class LabelListCommand extends ACommand implements ILabelListCommand
{
    /** @var array $columns */
    private $columns;

    /** @var Collection|ILabel $collection */
    private $collection;

    /**
     * LabelListCommand constructor.
     * @param array $columns
     */
    public function __construct($columns = ['*'])
    {
        $this->columns = $columns;
    }

    /**
     * @return Collection|ILabel
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
        $this->collection = Label::all($this->columns);

        $this->executed = true;
    }
}
