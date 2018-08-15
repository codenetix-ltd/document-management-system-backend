<?php

namespace App\Context;

use App\Contracts\Entity\IHasSubjectUser;
use App\Entities\User;
use Illuminate\Contracts\Auth\Authenticatable;

class UserAuthorizeContext extends AAuthorizeContext implements IHasSubjectUser
{
    /**
     * @var User
     */
    private $subjectUser;

    /**
     * UserAuthorizeContext constructor.
     * @param Authenticatable $user
     * @param User|null       $subjectUser
     */
    public function __construct(Authenticatable $user, User $subjectUser = null)
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
