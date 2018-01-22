<?php

namespace App\Commands\Paginators;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\Paginators\ITemplatePaginatorCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Template;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TemplatePaginatorCommand extends ACommand implements ITemplatePaginatorCommand
{
    /** @var LengthAwarePaginator $user */
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
        $this->paginator = Template::paginate(15);

        $this->executed = true;
    }

}