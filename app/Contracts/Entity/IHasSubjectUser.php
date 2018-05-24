<?php

namespace App\Contracts\Entity;

use App\Entities\User;

interface IHasSubjectUser
{
    public function getSubjectUser() : User;
    public function setSubjectUser(User $subjectUser) : void;
}
