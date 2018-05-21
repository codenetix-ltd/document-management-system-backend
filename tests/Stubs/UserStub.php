<?php

namespace Tests\Stubs;

use App\Entities\User;

class UserStub extends AbstractStub
{
    /**
     * @return string
     */
    protected function getModelName()
    {
        return User::class;
    }

    /**
     * @return array
     */
    protected function doBuildRequest()
    {
        /** @var User $user */
        $user = $this->getModel();
        return [
            'email' => $user->email,
            'fullName' => $user->fullName,
            'templateIds' => $user->templates->pluck('id')->toArray(),
            'avatarId' => $user->avatar->getId(),
        ];
    }

    /**
     * @return array
     */
    protected function doBuildResponse()
    {
        /** @var User $user */
        $user = $this->getModel();
        return [
            'fullName' => $user->fullName,
            'email' => $user->email,
            'templateIds' => $user->templates->pluck('id')->toArray(),
            'avatarId' => $user->avatar->getId(),
            'avatar' => [
                'name'=>$user->avatar->getOriginalName(),
                'url' => $user->avatar->getPath()
            ]
        ];
    }
}