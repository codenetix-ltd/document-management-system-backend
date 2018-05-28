<?php

namespace App\Handlers\Permissions;

use App\Contracts\Entity\IHasId;
use App\Contracts\Entity\IHasOwnerId;

class ByOwnerPermissionHandler
{
    private $user;
    private $entity;

    public function __construct(IHasId $user, IHasOwnerId $entity)
    {
        $this->user = $user;
        $this->entity = $entity;
    }

    public function handle(): bool
    {
        return $this->user->getId() == $this->entity->getOwnerId();
    }
}