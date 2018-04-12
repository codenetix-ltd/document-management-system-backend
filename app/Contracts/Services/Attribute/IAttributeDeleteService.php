<?php

namespace App\Contracts\Services\Attribute;

use App\Exceptions\FailedAttributeDeleteException;

interface IAttributeDeleteService
{
    /**
     * @param int $id
     * @return bool|null
     * @throws FailedAttributeDeleteException
     */
    public function delete(int $id) : ?bool;
}