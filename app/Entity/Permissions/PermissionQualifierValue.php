<?php
namespace App\Entity\Permissions;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class PermissionQualifierValue
{

    /**
     * @var int $id
     */
    private $id;

    /**
     * @var string $accessType
     */
    private $accessType;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id){
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getAccessType(): string
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
}