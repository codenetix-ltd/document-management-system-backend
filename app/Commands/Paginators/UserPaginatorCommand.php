<?php

namespace App\Commands\Paginators;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\Paginators\IUserPaginatorCommand;
use App\Contracts\Exceptions\ICommandException;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserPaginatorCommand extends ACommand implements IUserPaginatorCommand
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
        $this->paginator = User::paginate(15);

        $this->executed = true;
    }

}