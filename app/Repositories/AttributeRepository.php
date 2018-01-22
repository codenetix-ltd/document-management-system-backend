<?php
namespace App\Repositories;

use App\AttributeValue;
use App\Contracts\Repositories\IAttributeRepository;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class AttributeRepository implements IAttributeRepository
{
    public function getAttributeValuesByDocumentVersionId($documentVersionId){
        return AttributeValue::whereDocumentVersionId($documentVersionId)->get();
    }
}