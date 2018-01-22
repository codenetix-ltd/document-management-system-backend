<?php

namespace App\Contracts\Attributes;

interface ITableAttributeVisitor
{
    public function setIsLocked($value);
}