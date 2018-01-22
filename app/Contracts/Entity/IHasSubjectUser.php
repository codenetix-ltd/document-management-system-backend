<?php

namespace App\Contracts\Entity;

use App\User;

interface IHasSubjectUser
{
    public function getSubjectUser() : User;
    public function setSubjectUser(User $subjectUser) : void;
}
