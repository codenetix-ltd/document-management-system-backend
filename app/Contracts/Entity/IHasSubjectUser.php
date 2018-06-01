<?php

namespace App\Contracts\Entity;

use App\Entities\User;

interface IHasSubjectUser
{
    /**
     * @return User
     */
    public function getSubjectUser() : User;

    /**
     * @param User $subjectUser
     * @return void
     */
    public function setSubjectUser(User $subjectUser) : void;
}
