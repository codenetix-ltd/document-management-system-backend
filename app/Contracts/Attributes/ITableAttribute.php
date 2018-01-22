<?php

namespace App\Contracts\Attributes;

interface ITableAttribute
{
    public function visit(ITableAttributeVisitor $visitor);

    public function getTypeName() : string;
}