<?php

namespace App\Context;

use App\Contracts\Entity\IHasSubjectUser;
use App\Entities\User;

class UserAuthorizeContext extends AAuthorizeContext implements IHasSubjectUser
{
    private $subjectUser;

    public function __construct(User $user, User $subjectUser = null)
    {
        parent::__construct($user);
        $this->subjectUser = $subjectUser;
    }

    public function getSubjectUser(): User
    {
        return $this->subjectUser;
    }

    public function setSubjectUser(User $subjectUser): void
    {
        $this->subjectUser = $subjectUser;
    }
}
