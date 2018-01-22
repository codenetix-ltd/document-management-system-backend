<?php

namespace App\Commands\Paginators;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\Paginators\ILabelPaginatorCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Label;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class LabelPaginatorCommand extends ACommand implements ILabelPaginatorCommand
{
    private $paginator;

    /**
     * @return LengthAwarePaginator
     */
    public function getResult()
    {
        $this->isExecuted();

        return $this->paginator;
    }

    /**
     * @throws ICommandException
     * @return void
     */
    public function execute()
    {
        $this->paginator = Label::paginate(15);

        $this->executed = true;
    }

}