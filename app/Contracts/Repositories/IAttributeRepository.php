<?php

namespace App\Contracts\Repositories;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
interface IAttributeRepository
{
    public function getAttributeValuesByDocumentVersionId($documentVersionId);
}