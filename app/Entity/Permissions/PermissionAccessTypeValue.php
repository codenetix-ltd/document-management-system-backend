<?php
namespace App\Entity\Permissions;
use Illuminate\Support\Collection;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class PermissionAccessTypeValue
{

    /**
     * @var int $permissionId
     */
    private $permissionId;

    /**
     * @var int $accessType
     */
    private $accessType;

    /**
     * @var Collection $qualifiers
     */
    private $qualifiers;

    /**
     * @return int
     */
    public function getPermissionId(): int
    {
        return $this->permissionId;
    }

    /**
     * @param int $permissionId
     */
    public function setPermissionId(int $permissionId)
    {
        $this->permissionId = $permissionId;
    }

    /**
     * @return string
     */
    public function getAccessTypeId(): string
    {
        return $this->accessType;
    }

    /**
     * @param string $accessType
     */
    public function setAccessType(string $accessType)
    {
        $this->accessType = $accessType;
    }

    /**
     * @return Collection
     */
    public function getQualifiers(): ?Collection
    {
        return $this->qualifiers;
    }

    /**
     * @param Collection $qualifiers
     */
    public function setQualifiers(Collection $qualifiers)
    {
        $this->qualifiers = $qualifiers;
    }

}