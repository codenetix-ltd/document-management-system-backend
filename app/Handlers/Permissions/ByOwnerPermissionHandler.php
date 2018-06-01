<?php

namespace App\Handlers\Permissions;

use App\Contracts\Entity\IHasId;
use App\Contracts\Entity\IHasOwnerId;

class ByOwnerPermissionHandler
{
    /**
     * @var IHasId
     */
    private $user;

    /**
     * @var IHasOwnerId
     */
    private $entity;

    /**
     * ByOwnerPermissionHandler constructor.
     * @param IHasId      $user
     * @param IHasOwnerId $entity
     */
    public function __construct(IHasId $user, IHasOwnerId $entity)
    {
        $this->user = $user;
        $this->entity = $entity;
    }

    /**
     * @return boolean
     */
    public function handle(): bool
    {
        return $this->user->getId() == $this->entity->getOwnerId();
    }
}
