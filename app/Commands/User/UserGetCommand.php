<?php

namespace App\Commands\User;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\User\IUserGetCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Contracts\Models\IUser;
use App\Exceptions\CommandException;
use App\User;
use Exception;

class UserGetCommand extends ACommand implements IUserGetCommand
{
    /** @var int $id */
    private $id;

    /** @var IUser $user */
    private $user;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return IUser
     */
    public function getResult()
    {
        $this->isExecuted();

        return $this->user;
    }

    /**
     * @throws ICommandException
     * @return void
     */
    public function execute()
    {
        try {
            $user = User::findOrFail($this->id);
            $this->user = $user;
        } catch (Exception $e){
            throw new CommandException();
        }

        $this->executed = true;
    }

}