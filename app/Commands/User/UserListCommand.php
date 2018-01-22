<?php

namespace App\Commands\User;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\User\IUserListCommand;
use App\Contracts\Models\IUser;
use App\User;
use Illuminate\Database\Eloquent\Collection;

class UserListCommand extends ACommand implements IUserListCommand
{
    /** @var array $columns */
    private $columns;

    /** @var bool $mapFullName */
    private $mapFullName;

    /** @var Collection|IUser $collection */
    private $collection;

    /**
     * UserListCommand constructor.
     * @param array $columns
     * @param bool $mapFullName
     */
    public function __construct($columns = ['*'], $mapFullName = true)
    {
        $this->columns = $columns;
        $this->mapFullName = $mapFullName;
    }

    /**
     * @return Collection|IUser
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
        $users = User::all($this->columns);

        if (in_array('full_name', $this->columns) && $this->mapFullName) {
            $users = $users->map(function ($item) {
                $item->name = $item['full_name'];
                return $item;
            });
        }

        $this->collection = $users;

        $this->executed = true;
    }
}
