<?php

namespace App\Commands\Paginators;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\Paginators\IRolePaginatorCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RolePaginatorCommand extends ACommand implements IRolePaginatorCommand
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
        $this->paginator = Role::paginate(15);

        $this->executed = true;
    }

}