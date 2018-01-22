<?php

namespace App\Commands\User;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\User\IUserUpdateCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Contracts\Models\IUser;
use App\Exceptions\CommandException;
use App\User;
use Exception;

class UserUpdateCommand extends ACommand implements IUserUpdateCommand
{
    /** @var int $id */
    private $id;

    /** @var IUser $user */
    private $user;

    /** @var array $inputUserData */
    private $inputUserData;

    /**
     * UserUpdateCommand constructor.
     * @param $id
     * @param array $userData
     */
    public function __construct($id, array $userData)
    {
        $this->id = $id;
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
            $user = User::findOrFail($this->id);

            if(empty($this->inputUserData['password'])){
                unset($this->inputUserData['password']);
            }

            $user->fill($this->inputUserData);
            $user->save();

            if(isset($this->inputUserData['roles'])){
                if (!empty($this->inputUserData['roles'])) {
                    $user->roles()->sync($this->inputUserData['roles']);
                } else {
                    $user->roles()->detach();
                }
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