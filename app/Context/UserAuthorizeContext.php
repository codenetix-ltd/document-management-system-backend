<?php

namespace App\Context;

use App\Contracts\Entity\IHasSubjectUser;
use App\Entities\User;

class UserAuthorizeContext extends AAuthorizeContext implements IHasSubjectUser
{
    /**
     * @var User
     */
    private $subjectUser;

    /**
     * UserAuthorizeContext constructor.
     * @param User      $user
     * @param User|null $subjectUser
     */
    public function __construct(User $user, User $subjectUser = null)
    {
        parent::__construct($user);
        $this->subjectUser = $subjectUser;
    }

    /**
     * @return User
     */
    public function getSubjectUser(): User
    {
        return $this->subjectUser;
    }

    /**
     * @param User $subjectUser
     * @return void
     */
    public function setSubjectUser(User $subjectUser): void
    {
        $this->subjectUser = $subjectUser;
    }
}
