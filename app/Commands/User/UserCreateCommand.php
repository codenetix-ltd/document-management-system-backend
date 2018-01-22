<?php

namespace App\Commands\User;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\User\IUserCreateCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Contracts\Models\IUser;
use App\Exceptions\CommandException;
use App\User;
use Exception;

class UserCreateCommand extends ACommand implements IUserCreateCommand
{
    /**
     * @var IUser
     */
    private $user;

    /**
     * @var array
     */
    private $inputUserData;

    public function __construct(array $userData)
    {
        $this->inputUserData = $userData;
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
            $user = new User;
            $user->fill($this->inputUserData);
            $user->save();
            if (!empty($this->inputUserData['roles'])) {
                $user->roles()->sync($this->inputUserData['roles']);
            } else {
                $user->roles()->detach();
            }

            $user->factories()->sync(array_get($this->inputUserData , 'factory_id', []));
            $user->templates()->sync(array_get($this->inputUserData , 'template_id', []));

            $this->user = $user;
        } catch (Exception $e){
            throw new CommandException();
        }

        $this->executed = true;
    }

}