<?php

namespace App\Services;

use App\Contracts\CommandInvokers\IAtomCommandInvoker;
use App\Contracts\Commands\User\IUserSetAvatarCommand;
use App\Contracts\Commands\User\IUserUpdateCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Contracts\Models\IUser;
use App\Contracts\Services\IUserUpdateService;
use App\Events\User\UserUpdateEvent;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class UserUpdateService extends AService implements IUserUpdateService
{
    /** @var int $id */
    private $id;

    /** @var array $userData */
    private $userData;

    /** @var UploadedFile $file */
    private $file;

    /** @var IUser $user */
    private $user;


    public function __construct(Container $container, $id, array $userData, UploadedFile $file = null)
    {
        parent::__construct($container);

        $this->id = $id;
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

        $userUpdateCommand = app()->makeWith(IUserUpdateCommand::class, [
            'id' => $this->id,
            'userData' => $this->userData
        ]);
        $invoker->invoke($userUpdateCommand);
        $user = $userUpdateCommand->getResult();

        if ($this->file) {
            $userSetAvatarCommand = app()->makeWith(IUserSetAvatarCommand::class, [
                'user' => $user,
                'file' => $this->file
            ]);
            $invoker->invoke($userSetAvatarCommand);
            $user = $userSetAvatarCommand->getResult();
        }

        $this->user = $user;

        event(new UserUpdateEvent(Auth::user(), $user));

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