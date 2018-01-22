<?php

namespace App\Commands\User;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\User\IUserDeleteCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Events\User\UserDeleteEvent;
use App\Exceptions\CommandException;
use App\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class UserDeleteCommand extends ACommand implements IUserDeleteCommand
{
    /** @var int $id */
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @throws ICommandException
     * @return void
     */
    public function execute()
    {
        try {
            $user = User::findOrFail($this->id);
            event(new UserDeleteEvent(Auth::user(), $user));
            $user->delete();
        } catch (Exception $e){
            throw new CommandException();
        }

        $this->executed = true;
    }

}