<?php

namespace App\Contracts\Repositories;

use App\Contracts\Models\IAttribute;

interface IAttributeRepository
{
    public function getAttributeValuesByDocumentVersionId($documentVersionId);

    public function create(IAttribute $attribute): IAttribute;
}