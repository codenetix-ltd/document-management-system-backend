<?php

namespace App\Services;

use App\Contracts\CommandInvokers\IAtomCommandInvoker;
use App\Contracts\Commands\Role\IRoleGetCommand;
use App\Contracts\Commands\User\IUserCreateCommand;
use App\Contracts\Commands\User\IUserSetAvatarCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Contracts\Models\IUser;
use App\Contracts\Services\IUserCreateService;
use App\Events\User\UserCreateEvent;
use App\Role;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class UserCreateService extends AService implements IUserCreateService
{
    /** @var array $userData */
    private $userData;

    /** @var UploadedFile $file */
    private $file;

    /** @var IUser $user */
    private $user;

    /**
     * UserCreateService constructor.
     * @param Container $container
     * @param array $userData
     * @param UploadedFile $file
     */
    public function __construct(Container $container, array $userData, UploadedFile $file = null)
    {
        parent::__construct($container);

        $this->userData = $userData;
        $this->file = $file;
    }


    /**
     * @throws ICommandException
     * @return void
     */
    public function execute()
    {
        $invoker = app()->make(IAtomCommandInvoker::class);

        $userCreateCommand = app()->makeWith(IUserCreateCommand::class, [
            'userData' => $this->userData
        ]);
        $invoker->invoke($userCreateCommand);
        $user = $userCreateCommand->getResult();

        if ($this->file) {
            $userSetAvatarCommand = app()->makeWith(IUserSetAvatarCommand::class, [
                'user' => $user,
                'file' => $this->file
            ]);
            $invoker->invoke($userSetAvatarCommand);
            $user = $userSetAvatarCommand->getResult();
        }

        $role = Role::whereName('owner')->first();
        if ($role) {
            $user->roles()->syncWithoutDetaching($role->id);
        }



        $this->user = $user;

        event(new UserCreateEvent(Auth::user(), $user));

        $this->executed = true;
    }

    /**
     * @return IUser
     */
    public function getResult()
    {
        $this->isExecuted();

        return $this->user;
    }
}